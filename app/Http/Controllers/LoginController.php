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
            $user = User::first();
            if ($user) {
                Auth::login($user);
                return redirect()->route('admin');
            }
            session()->flash('error', 'User not found.');
            return redirect()->back();
        }

        session()->flash('error', 'Invalid password.');
        
        return redirect()->back();
    }
    
}
