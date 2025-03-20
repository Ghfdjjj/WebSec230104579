<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Role;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    
     public function run()
     {
         // Ensure the admin role exists
         if (!Role::where('name', 'admin')->exists()) {
             Role::create(['name' => 'admin']);
         }
     
         // Check if the admin user already exists
         if (!User::where('email', 'admin@gmail.com')->exists()) {
             $user = User::create([
                 'name' => 'admin',
                 'email' => 'admin@gmail.com',
                 'password' => bcrypt('password'),
             ]);
     
             $user->assignRole('admin');
         }
        }

    }