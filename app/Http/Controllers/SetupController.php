<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SetupController extends Controller
{
    /**
     * Set up the admin user.
     */
    public function setupAdmin()
    {
        // Check if we already have any users
        $user = User::first();

        if ($user) {
            // Make the first user an admin
            $user->is_admin = true;
            $user->save();
            
            return 'First user has been made an admin. You can now go to <a href="'.route('admin.dashboard').'">admin dashboard</a>.';
        } else {
            // Create a new admin user
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);
            
            return 'New admin user created with email: admin@example.com and password: password. You can now <a href="'.route('login').'">login</a> and go to the <a href="'.route('admin.dashboard').'">admin dashboard</a>.';
        }
    }
} 