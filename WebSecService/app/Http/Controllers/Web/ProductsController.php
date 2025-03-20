<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    // Protect routes except listing (public listing)
    public function __construct()
    {
        $this->middleware('auth')->except(['list', 'index']);
    }

    // Private method to ensure only admin users can perform CRUD operations
    private function ensureIsAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    // List products with filters (publicly accessible)
    public function list(Request $request)
    {
        $query = Product::query();

        if ($request->has('keywords')) {
            $query->where('name', 'like', '%' . $request->keywords . '%');
        }
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->has('order_by')) {
            $direction = $request->order_direction ?? 'ASC';
            $query->orderBy($request->order_by, $direction);
        }

        $products = $query->get();
        return view('products.list', compact('products'));
    }

    // Public listing of all products (accessible to everyone)
    public function index(Request $request)
    {
        $products = Product::all();
        return view('products.list', compact('products'));
    }

    // Show form for creating a new product (admin only)
    public function create()
    {
        $this->ensureIsAdmin();
        return view('products.create');
    }

    // Store a new product (admin only)
    public function store(Request $request)
    {
        $this->ensureIsAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'required|image',
            'model' => 'nullable|string',
        ]);

        $photoPath = $request->file('photo')->store('product_images', 'public');

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->photo = $photoPath;
        $product->code = Str::random(10);
        $product->model = $request->model ?? 'DEFAULT_MODEL';
        $product->save();

        return redirect()->route('products_list')->with('success', 'Product added successfully.');
    }

    // Show form for editing a product (admin only)
    public function edit(Product $product)
    {
        $this->ensureIsAdmin();
        return view('products.edit', compact('product'));
    }

    // Save or update product (admin only)
    public function save(Request $request, Product $product = null)
    {
        $this->ensureIsAdmin();

        $request->validate([
            'code'        => 'required|string|max:32',
            'name'        => 'required|string|max:128',
            'model'       => 'required|string|max:256',
            'description' => 'required|string|max:1024',
            'price'       => 'required|numeric',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if (!$product) {
            $product = new Product();
        }

        $product->fill($request->except('photo'));

        // Handle image upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('product_images', 'public');
            $product->photo = $photoPath;
        }

        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully!');
    }

    // Delete a product (admin only)
    public function destroy(Product $product)
    {
        $this->ensureIsAdmin(); // This will abort if the user is not an admin.

        // Delete the product image if it exists
        if ($product->photo && Storage::exists('public/' . $product->photo)) {
            Storage::delete('public/' . $product->photo);
        }

        // Delete the product from the database
        $product->delete();

        return redirect()->route('products_list')->with('success', 'Product deleted successfully.');
    }
}
