<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        Log::info('Admin accessing dashboard');

        $totalUsers       = User::where('role', 'user')->count();
        $totalSupervisors = User::where('role', 'supervisor')->count();
        $totalAdmins      = User::where('role', 'admin')->count();

        $logs = LogEntry::with('user')
            ->latest()
            ->take(50)
            ->get();

        Log::info('Admin dashboard loaded');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSupervisors',
            'totalAdmins',
            'logs'
        ));
    }

    public function users()
    {
        Log::info('Admin accessing users list');

        $users = User::withTrashed()
                    ->orderBy('role')
                    ->orderBy('name')
                    ->get();

        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        Log::info('Admin accessing create user form');
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        Log::info('Admin attempting to create user');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['user', 'supervisor', 'admin'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Log::info('User created successfully by admin');

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully!');
    }

    public function editUser(User $user)
    {
        Log::info('Admin accessing edit user form');

        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        Log::info('Admin attempting to update user');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['user', 'supervisor', 'admin'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
            Log::info('Password updated for user');
        }

        $user->save();

        Log::info('User updated successfully by admin');

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

    public function deleteUser(User $user)
    {
        Log::info('Admin attempting to delete user');

        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {

            Log::error('Admin attempted to delete their own account');

            return redirect()->route('admin.users')
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        Log::info('User deleted successfully by admin');

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    public function restoreUser($id)
    {
        Log::info('Admin attempting to restore user');

        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        Log::info('User restored successfully by admin');

        return redirect()->route('admin.users')
            ->with('success', 'User restored successfully!');
    }

    public function forceDeleteUser($id)
    {
        Log::info('Admin attempting to permanently delete user');

        $user = User::withTrashed()->findOrFail($id);
        
        // Prevent admin from force deleting themselves
        if ($user->id === auth()->id()) {
            Log::error('Admin attempted to permanently delete their own account');

            return redirect()->route('admin.users')
                ->with('error', 'You cannot permanently delete your own account!');
        }

        $user->forceDelete();

        Log::info('User permanently deleted by admin');

        return redirect()->route('admin.users')
            ->with('success', 'User permanently deleted!');
    }
}
