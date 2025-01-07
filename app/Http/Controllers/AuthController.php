<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 2,
        ]);

        Auth::login($user);

        return Inertia::render('Dashboard'); // Redirect to dashboard after signup
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Check if the email exists in the database
        $user = \App\Models\User::where('email', $request->email)->first();
    
        // If email doesn't exist, return an error
        if (!$user) {
            return back()->withErrors([
                'email' => 'There is no existing email on our records.',
                'password' => 'Incorrect password, please try again.'
            ]);
        }
    
        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            return redirect()->intended('dashboard')->with([
                'message' => 'Logged in successfully'
            ]);
        }
    
        // If login attempt fails, return a password error
        return back()->withErrors([
            'password' => 'Incorrect password, please try again.'
        ]);
    }    
    
    
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/')->with([
            'message' => 'Logged out successfully'
        ]);
    }
}