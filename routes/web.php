<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogEntryController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// 1. LANDING PAGE
Route::get('/', function () {
    if (!auth()->check()) {
        return view('landing');
    }

    return match (auth()->user()->role) {
        'supervisor' => redirect()->route('supervisor.index'),
        'admin' => redirect()->route('admin.dashboard'),
        default => redirect()->route('dashboard'),
    };
})->name('landing');

// 2. GUEST-ONLY ROUTES (login + register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. LOGOUT - available when logged in
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// 4. AUTHENTICATED USERS - role-based routing
Route::middleware('auth')->group(function () {
    
    // === Regular Users (Interns) - NOT supervisors ===
    Route::middleware(RoleMiddleware::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logs/weekly', [LogEntryController::class, 'weeklyLogs'])->name('logs.weekly');
        Route::resource('logs', LogEntryController::class)->except(['show']);
    });

    // === Supervisors ===
    Route::prefix('supervisor')
        ->name('supervisor.')
        ->middleware('role:supervisor')
        ->controller(SupervisorController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}/logs', 'showUserLogs')->name('user.logs');
            Route::get('/{id}/logs/create', 'createLog')->name('log.create');
            Route::post('/{id}/logs/store', 'storeLog')->name('log.store');
            Route::get('/logs/{id}/edit', 'editLog')->name('log.edit');
            Route::put('/logs/{id}', 'updateLog')->name('log.update');
            Route::delete('/logs/{id}', 'deleteLog')->name('log.delete');
            Route::post('/logs/{id}/approve', 'approve')->name('log.approve');
            Route::post('/logs/{id}/reject', 'reject')->name('log.reject');
            Route::post('/logs/{id}/reset', 'resetToPending')->name('log.reset');
        });

    // === Admins ===
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->controller(AdminController::class)
        ->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/users', 'users')->name('users');
            Route::get('/users/create', 'createUser')->name('users.create');
            Route::post('/users', 'storeUser')->name('users.store');
            Route::get('/users/{user}/edit', 'editUser')->name('users.edit');
            Route::put('/users/{user}', 'updateUser')->name('users.update');
            Route::delete('/users/{user}', 'deleteUser')->name('users.destroy');
            Route::patch('/users/{id}/restore', 'restoreUser')->name('users.restore');
            Route::delete('/users/{id}/force-delete', 'forceDeleteUser')->name('users.force-delete');
        });
});