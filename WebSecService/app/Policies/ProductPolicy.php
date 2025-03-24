<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Anyone can view products (public catalog)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Product $product): bool
    {
        // Anyone can view active products
        if ($product->is_active) {
            return true;
        }

        // Only admins and employees can view inactive products
        return $user && in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admins and employees can create products
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Only admins and employees can update products
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Only admins can delete products
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can manage product inventory.
     */
    public function manageInventory(User $user): bool
    {
        // Only admins and employees can manage inventory
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can purchase the product.
     */
    public function purchase(?User $user, Product $product): bool
    {
        // Must be logged in and product must be active with stock
        return $user && $product->is_active && $product->stock_quantity > 0;
    }
}
