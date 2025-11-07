<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogEntryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupervisorController;

// Guest routes (accessible when not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/log-entries', [LogEntryController::class, 'store'])->name('log.store');
});

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'role:supervisor'])->group(function () {
    Route::get('/supervisor', [SupervisorController::class, 'index'])->name('supervisor.index');
    Route::get('/supervisor/user/{id}', [SupervisorController::class, 'showUserLogs'])->name('supervisor.user.logs');
});






