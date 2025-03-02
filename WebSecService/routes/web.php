<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;


Route::get('/', function () {
    return view('Welcome');
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
Route::resource('grades', GradeController::class);

// Users routes
Route::resource('users', UserController::class);