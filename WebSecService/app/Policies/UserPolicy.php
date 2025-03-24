<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'employee']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Users can view their own profile
        if ($user->id === $model->id) {
            return true;
        }

        // Admins can view any user
        if ($user->role === 'admin') {
            return true;
        }

        // Employees can view customers
        if ($user->role === 'employee' && $model->role === 'customer') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Users can update their own profile
        if ($user->id === $model->id) {
            return true;
        }

        // Admins can update any user
        if ($user->role === 'admin') {
            return true;
        }

        // Employees can update customers
        if ($user->role === 'employee' && $model->role === 'customer') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Only admins can delete users
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can manage employee accounts.
     */
    public function manageEmployees(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can manage customer accounts.
     */
    public function manageCustomers(User $user): bool
    {
        return in_array($user->role, ['admin', 'employee']);
    }
}
