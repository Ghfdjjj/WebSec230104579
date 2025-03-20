<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\Auth\UsersController; // Updated import
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\StudentController; // Updated import
use App\Http\Controllers\Web\HomeController; // Ensure this matches the namespace
use App\Http\Controllers\ProductController; // Import ProductController
use App\Http\Controllers\Auth\ProfileController; // Updated import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Ensure this line is added

// Authentication Routes
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout'); // Ensure this line is added

// Product Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductsController::class, 'index'])->name('products_list');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products_edit');
    Route::post('/products/{product}', [ProductsController::class, 'save'])->name('products_save');
    Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
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

// Grades routes

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
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::resource('students', \App\Http\Controllers\Web\StudentController::class);
});

Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Add a route for the profile page
Route::get('/profile', [UsersController::class, 'profile'])->name('profile')->middleware('auth');
