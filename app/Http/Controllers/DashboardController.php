<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry; // Import your model
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // fetch all logs for the logged-in user
        $logs = LogEntry::where('user_id', Auth::id())->latest()->get();

        // pass $logs to the dashboard view
        return view('dashboard', compact('logs'));
    }
}
