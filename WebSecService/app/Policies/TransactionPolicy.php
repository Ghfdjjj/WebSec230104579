<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admins and employees can view all transactions
        if (in_array($user->role, ['admin', 'employee'])) {
            return true;
        }

        // Customers can only view their own transactions
        return $user->role === 'customer';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        // Users can view their own transactions
        if ($user->id === $transaction->user_id) {
            return true;
        }

        // Admins and employees can view any transaction
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admins and employees can create transactions (add credit)
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        // Only admins can update transactions
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        // Only admins can delete transactions
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can process credit additions.
     */
    public function addCredit(User $user): bool
    {
        // Only admins and employees can add credit
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can view transaction history.
     */
    public function viewHistory(User $user): bool
    {
        // All authenticated users can view transaction history
        return true;
    }

    /**
     * Determine whether the user can process refunds.
     */
    public function processRefund(User $user, Transaction $transaction): bool
    {
        // Only admins and employees can process refunds
        return in_array($user->role, ['admin', 'employee']);
    }
}
