<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        Log::info('User accessing dashboard');

        if (auth()->user()->role === 'supervisor') {

            Log::info('Supervisor redirected to supervisor dashboard');
            
            return redirect()->route('supervisor.index');
        }

        $logs = LogEntry::where('user_id', Auth::id())->latest()->get();
        
        Log::info('Dashboard loaded successfully');

        return view('dashboard', compact('logs'));
    }
}
