<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'password' => 'required|string',
        ]);
        
        // Check if the password matches the environment variable
        
        if ($request->password == env('ADMIN_PASSWORD')) {

            // Check if the user exists
            $user = User::first();
            if (!$user) {
                // If no user exists, create a new user
                $user = User::create([
                    'name' => 'GWM Nepal',
                    'email' => 'admin@gwmnepal.com.np',
                    'password' => bcrypt($request->password),
                ]);

                Auth::login($user);

                return redirect()->route('admin');

            } else {
                // If user exists, log them in
                Auth::login($user);
                return redirect()->route('admin');
            }
        }

        session()->flash('error', 'Invalid password.');
        
        return redirect()->back();
    }
    
}
