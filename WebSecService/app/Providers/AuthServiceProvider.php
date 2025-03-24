<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\User;
use App\Policies\ProductPolicy;
use App\Policies\PurchasePolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
        Purchase::class => PurchasePolicy::class,
        Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates for employee management
        Gate::define('manage-employees', [UserPolicy::class, 'manageEmployees']);
        Gate::define('manage-customers', [UserPolicy::class, 'manageCustomers']);

        // Define gates for product management
        Gate::define('manage-inventory', [ProductPolicy::class, 'manageInventory']);

        // Define gates for transaction management
        Gate::define('process-refund', [TransactionPolicy::class, 'processRefund']);
        Gate::define('add-credit', [TransactionPolicy::class, 'addCredit']);
    }
}
