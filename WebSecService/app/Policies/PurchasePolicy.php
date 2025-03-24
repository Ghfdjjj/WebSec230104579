<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admins and employees can view all purchases
        if (in_array($user->role, ['admin', 'employee'])) {
            return true;
        }

        // Customers can view their own purchases
        return $user->role === 'customer';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Purchase $purchase): bool
    {
        // Users can view their own purchases
        if ($user->id === $purchase->user_id) {
            return true;
        }

        // Admins and employees can view any purchase
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can create a purchase
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Purchase $purchase): bool
    {
        // Only admins can update purchases
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Purchase $purchase): bool
    {
        // Only admins can delete purchases
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can process refunds.
     */
    public function processRefund(User $user, Purchase $purchase): bool
    {
        // Only admins and employees can process refunds
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can view purchase history.
     */
    public function viewHistory(User $user): bool
    {
        // All authenticated users can view purchase history
        return true;
    }
}
