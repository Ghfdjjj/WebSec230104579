<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    /**
     * Show the cart contents.
     */
    public function cart()
    {
        $cart = Session::get('cart', []);
        $products = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();
            
            foreach ($products as $product) {
                $quantity = $cart[$product->id];
                $total += $product->price * $quantity;
            }
        }

        return view('store.cart', compact('products', 'cart', 'total'));
    }

    /**
     * Add a product to cart.
     */
    public function addToCart(Request $request, Product $product)
    {
        if (!$product->is_active || $product->stock_quantity <= 0) {
            return back()->with('error', 'Product is not available.');
        }

        $cart = Session::get('cart', []);
        $quantity = ($cart[$product->id] ?? 0) + 1;

        if ($quantity > $product->stock_quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart[$product->id] = $quantity;
        Session::put('cart', $cart);
        Session::put('cart_count', array_sum($cart));

        return back()->with('success', 'Product added to cart.');
    }

    /**
     * Remove a product from cart.
     */
    public function removeFromCart(Product $product)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            Session::put('cart', $cart);
            Session::put('cart_count', array_sum($cart));
        }

        return back()->with('success', 'Product removed from cart.');
    }

    /**
     * Process the checkout.
     */
    public function checkout(StorePurchaseRequest $request)
    {
        $cart = Session::get('cart', []);
        $user = $request->user();
        $purchases = [];

        try {
            DB::beginTransaction();

            foreach ($cart as $productId => $quantity) {
                $product = Product::findOrFail($productId);
                $amount = $product->price * $quantity;

                $purchase = new Purchase([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_amount' => $amount,
                    'status' => 'pending'
                ]);

                $purchases[] = $purchase;
            }

            // Process all purchases
            foreach ($purchases as $purchase) {
                $purchase->save();
                $purchase->process();
            }

            // Clear the cart
            Session::forget(['cart', 'cart_count']);
            
            DB::commit();
            return redirect()->route('purchase.history')->with('success', 'Purchase completed successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show purchase history.
     */
    public function history(Request $request)
    {
        $purchases = Purchase::where('user_id', $request->user()->id)
                           ->with(['product'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);

        return view('store.purchase-history', compact('purchases'));
    }

    /**
     * Show a specific purchase.
     */
    public function show(Purchase $purchase)
    {
        $this->authorize('view', $purchase);
        $purchase->load(['product', 'transaction']);
        
        return view('store.purchase-details', compact('purchase'));
    }
}
