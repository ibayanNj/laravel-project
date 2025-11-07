<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if supervisor already exists
        if (!User::where('email', 'supervisor@example.com')->exists()) {
            User::create([
                'name' => 'Supervisor Account',
                'email' => 'supervisor@example.com',
                'password' => Hash::make('password123'), // you can change this
                'role' => 'supervisor', // make sure you have a 'role' column in users table
            ]);
        }
    }
}
