<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Already protected by auth middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart' => ['required', 'array', 'min:1'],
            'cart.*' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $cart = Session::get('cart', []);
            if (empty($cart)) {
                $validator->errors()->add('cart', 'Your cart is empty.');
                return;
            }

            $total = 0;
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                
                if (!$product || !$product->is_active) {
                    $validator->errors()->add('cart', "Product {$productId} is no longer available.");
                    continue;
                }

                if ($product->stock_quantity < $quantity) {
                    $validator->errors()->add('cart', "Not enough stock available for {$product->name}.");
                    continue;
                }

                $total += $product->price * $quantity;
            }

            if ($total > $this->user()->credit_balance) {
                $validator->errors()->add('cart', 'Insufficient credit balance for this purchase.');
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cart.required' => 'Your cart cannot be empty.',
            'cart.array' => 'Invalid cart format.',
            'cart.min' => 'Your cart must contain at least one item.',
            'cart.*.integer' => 'Invalid quantity format.',
            'cart.*.min' => 'Quantity must be at least 1.',
        ];
    }
}
