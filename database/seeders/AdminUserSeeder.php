<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Delete old admin if exists (optional)
        User::where('email', 'admin@internlog.com')->delete();

        User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@internlog.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('admin123'), // change this later!
            'role'              => 'admin',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@internlog.com');
        $this->command->info('Password: admin123');
    }
}