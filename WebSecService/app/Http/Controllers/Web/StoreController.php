<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display the store homepage with products.
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')
                         ->paginate(12);

        return view('store.index', compact('products'));
    }

    /**
     * Display a specific product.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        return view('store.show', compact('product'));
    }
}
