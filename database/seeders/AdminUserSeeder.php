<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we already have any users
        $user = User::first();

        if ($user) {
            // Make the first user an admin
            $user->is_admin = true;
            $user->save();
            
            $this->command->info('First user has been made an admin.');
        } else {
            // Create a new admin user
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);
            
            $this->command->info('New admin user created with email: admin@example.com and password: password');
        }
    }
} 