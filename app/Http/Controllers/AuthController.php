<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        Log::info('Login page accessed');

        return view('auth.login');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt started');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            Log::info('User logged in successfully');

            $redirectTo = match (auth()->user()->role) {
                'admin' => route('admin.dashboard'),
                'supervisor' => route('supervisor.index'),
                default => route('dashboard'),
            };

            return redirect($redirectTo)
            ->with('success', 'Welcome back'. (auth()->user()->name ? ', ' . auth()->user()->name : '') . '!');
        }

        Log::error('Failed login attempt');

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    // Show registration form
    public function showRegister()
    {
        Log::info('Registration page accessed');

        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        Log::info('Registration attempt started');

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(8)],
            ],
            [
                'password.confirmed' => 'The password and confirmation do not match.',
            ],
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Log::info('User registered successfully');

        return redirect()->route('login')
            ->with('success', 'Account created successfully! Please log in.');
    }

    // Handle logout
    public function logout(Request $request)
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email;

        Log::info('User logging out');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out successfully');

        return redirect()->route('landing');
    }
}