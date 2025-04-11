<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $adminPassword = env('ADMIN_PASSWORD');

        // Check if ADMIN_PASSWORD is configured
        if ($adminPassword === null) {
            abort(500, 'Admin password not configured.');
        }

        // Securely compare input with the environment password
        if (!hash_equals($adminPassword, $request->password)) {
            session()->flash('error', 'Invalid password.');
            return redirect()->back();
        }

        // Define admin email to ensure uniqueness
        $adminEmail = 'admin@gwmnepal.com.np';

        // Find or create the admin user
        $user = User::where('email', $adminEmail)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'GWM Nepal',
                'email' => $adminEmail,
                'password' => bcrypt($adminPassword),
            ]);
        } else {
            // Update password if it doesn't match the current env password
            if (!Hash::check($adminPassword, $user->password)) {
                $user->password = bcrypt($adminPassword);
                $user->save();
            }
        }

        Auth::login($user);

        return redirect()->route('admin');
    }
}