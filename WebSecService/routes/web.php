<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\StoreController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\PurchaseController;
use App\Http\Controllers\Web\TransactionController;
use App\Http\Controllers\Auth\UsersController;

// Public Routes
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/products/{product}', [StoreController::class, 'show'])->name('store.product.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Customer Routes
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Cart & Purchases
    Route::get('/cart', [PurchaseController::class, 'cart'])->name('cart.index');
    Route::post('/cart/add/{product}', [PurchaseController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [PurchaseController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/purchase', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchases', [PurchaseController::class, 'history'])->name('purchase.history');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchase.show');
});

// Employee Routes
Route::middleware(['auth', 'role:employee'])->prefix('admin')->name('admin.')->group(function () {
    // Product Management
    Route::resource('products', ProductsController::class);
    
    // Customer Management
    Route::get('/customers', [UsersController::class, 'customers'])->name('customers.index');
    Route::get('/customers/{user}', [UsersController::class, 'show'])->name('customers.show');
    Route::post('/customers/{user}/credit', [TransactionController::class, 'addCredit'])->name('customers.credit.add');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Employee Management
    Route::get('/employees', [UsersController::class, 'employees'])->name('employees.index');
    Route::get('/employees/create', [UsersController::class, 'createEmployee'])->name('employees.create');
    Route::post('/employees', [UsersController::class, 'storeEmployee'])->name('employees.store');
    Route::delete('/employees/{user}', [UsersController::class, 'destroyEmployee'])->name('employees.destroy');
    
    // Transaction Management
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});

Route::get('/even-numbers', function () {
    return view('even_numbers');
});

Route::get('/prime-numbers', function () {
    return view('prime_numbers');
});

Route::get('/multiplication-table', function () {
    return view('multiplication-table');
});

Route::get('/MiniTest', function () {
    $bill = (object) [
        'items' => [
            ['name' => 'Apple', 'quantity' => 2, 'price' => 1.50],
            ['name' => 'Bread', 'quantity' => 1, 'price' => 2.50],
            ['name' => 'Milk', 'quantity' => 3, 'price' => 1.00],
        ],
        'total' => 8.50
    ];
    return view('MiniTest', ['bill' => $bill]);
});

Route::get('/Transcript', function () {
    $transcript = [
        ['course' => 'Mathematics', 'grade' => 'A'],
        ['course' => 'Science', 'grade' => 'B'],
        ['course' => 'History', 'grade' => 'C'],
    ];
    return view('Transcript', ['Transcript' => $transcript]);
});

// Tabs route
Route::get('/tabs', function () {
    $users = App\Models\User::all();
    $grades = App\Models\Grade::all();
    return view('tabs', compact('users', 'grades'));
});

// Admin User Management Routes
Route::middleware('auth')->group(function () {
    Route::get('users', [UsersController::class, 'index'])->name('users_index');
    Route::get('users/edit/{user}', [UsersController::class, 'editUser'])->name('users_edit');
    Route::post('users/update/{user}', [UsersController::class, 'updateUser'])->name('users_update');
    Route::get('users/delete/{user}', [UsersController::class, 'deleteUser'])->name('users_delete');
    Route::post('/users/{user}/assign-role', [UsersController::class, 'assignRole']);
    Route::delete('/users/{user}/remove-role/{role}', [UsersController::class, 'removeRole']);
    Route::post('/users/{user}/give-permission', [UsersController::class, 'givePermission']);
    Route::delete('/users/{user}/revoke-permission/{permission}', [UsersController::class, 'revokePermission']);
});

// Student routes
Route::middleware(['auth'])->group(function () {
    Route::get('/students', [App\Http\Controllers\Web\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [App\Http\Controllers\Web\StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [App\Http\Controllers\Web\StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [App\Http\Controllers\Web\StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [App\Http\Controllers\Web\StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [App\Http\Controllers\Web\StudentController::class, 'destroy'])->name('students.destroy');
});

Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('/home', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
