<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogEntry;

class SupervisorController extends Controller
{
    // Show list of all users
    public function index()
    {
        // Fetch users with role 'user' only
        $users = User::where('role', 'user')->get();
        return view('supervisor.index', compact('users'));
    }

    // Show log entries for a specific user
    public function showUserLogs($id)
    {
        $user = User::findOrFail($id);
        $entries = LogEntry::where('user_id', $user->id)->get();

        return view('supervisor.user_logs', compact('user', 'entries'));
    }
}
