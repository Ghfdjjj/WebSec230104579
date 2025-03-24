<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@websec.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'credit_balance' => 1000.00,
        ]);
    }
}
