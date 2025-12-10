<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($role === null) {
            if ($user->role === 'supervisor') {
                return redirect()->route('supervisor.index');
            }
            return $next($request);
        }

        if ($user->role !== $role) {
            // Redirect based on actual user role
            return match($user->role) {
                'supervisor' => redirect()->route('supervisor.index'),
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('dashboard'),
            };
        }

        return $next($request);
    }
}