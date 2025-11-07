<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Auth;

class LogEntryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'hours_worked' => 'required|integer|min:1',
            'tasks' => 'required|string',
            'skills' => 'nullable|string',
            'challenges' => 'nullable|string',
            'learnings' => 'nullable|string',
        ]);

        LogEntry::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'hours_worked' => $request->hours_worked,
            'tasks' => $request->tasks,
            'skills' => $request->skills,
            'challenges' => $request->challenges,
            'learnings' => $request->learnings,
        ]);

        return redirect()->back()->with('success', 'Log entry added successfully!');
    }
}

