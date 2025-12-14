<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LogEntryController extends Controller
{
    public function index()
    {
        Log::info('User accessing log entries index');

        $logs = LogEntry::where('user_id', Auth::id())->orderBy('date', 'desc')->get();

        return view('logs.index', compact('logs'));
    }

    public function create()
    {
        Log::info('User accessing create log entry form');

        return view('logs.create');
    }

    public function store(Request $request)
    {
        Log::info('Attempting to create log entry');

        $request->validate(
            [
                'date' => ['required', 'date', 'unique:log_entries,date,NULL,id,user_id,' . Auth::id()],
                'hours_worked' => 'required|integer|min:1|max:13',
                'tasks' => 'required|string',
                'skills' => 'nullable|string',
                'challenges' => 'nullable|string',
                'learnings' => 'nullable|string',
            ],
            [
                'date.unique' => 'You have already created a log entry for this date. Please choose a different date or edit your existing entry.',
            ],
        );

        $logEntry = LogEntry::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'hours_worked' => $request->hours_worked,
            'tasks' => $request->tasks,
            'skills' => $request->skills,
            'challenges' => $request->challenges,
            'learnings' => $request->learnings,
        ]);

        Log::info('Log entry created successfully');

        return redirect()->route('logs.index')->with('success', 'Log entry added successfully!');
    }

    public function weeklyLogs()
    {
        Log::info('User accessing weekly logs view');

        $logs = LogEntry::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function ($log) {
                // Group by week (returns week start date)
                return Carbon::parse($log->date)->startOfWeek()->format('Y-m-d');
            });

        $weeklyData = $logs
            ->map(function ($weekLogs, $weekStart) {
                $start = Carbon::parse($weekStart);
                $end = $start->copy()->endOfWeek();

                return [
                    'week_start' => $weekStart,
                    'week_end' => $end->format('Y-m-d'),
                    'week_number' => $start->weekOfYear,
                    'total_hours' => $weekLogs->sum('hours_worked'),
                    'entry_count' => $weekLogs->count(),
                    'week_label' => $start->format('M j') . ' - ' . $end->format('M j, Y'),
                    'logs' => $weekLogs->map(function ($log) {
                        return [
                            'id' => $log->id,
                            'date' => $log->date,
                            'date_formatted' => Carbon::parse($log->date)->format('D, M j'),
                            'hours_worked' => $log->hours_worked,
                            'tasks' => $log->tasks,
                        ];
                    }),
                ];
            })
            ->values();

        return view('logs.weekly', compact('weeklyData'));
    }


public function edit(LogEntry $log)
{
    Log::info('User accessing edit log entry form');

    // Check ownership
    if ($log->user_id !== Auth::id()) {
        Log::error('Unauthorized edit attempt');
        abort(403, 'You are not authorized to edit this log entry.');
    }

    // Check if approved
    if ($log->status === 'approved') {
        Log::warning('Attempt to edit approved log entry');
        abort(403, 'Cannot edit approved log entries. This entry is locked.');
    }

    return view('logs.edit', compact('log'));
}

public function update(Request $request, LogEntry $log)
{
    // Check ownership
    if ($log->user_id !== Auth::id()) {
        return redirect()->route('dashboard')
            ->with('error', 'You are not authorized to edit this log entry.');
    }

    // Check if approved (double-check on update too)
    if ($log->status === 'approved') {
        return redirect()->route('logs.index')
            ->with('error', 'Cannot update approved log entries.');
    }

    $validated = $request->validate([
        'date' => 'required|date',
        'hours_worked' => 'required|numeric|min:0.5|max:24',
        'tasks' => 'required|string',
        'skills' => 'nullable|string',
        'challenges' => 'nullable|string',
        'learnings' => 'nullable|string',
    ]);

    $log->update($validated);

    Log::info('Log entry updated successfully');

    return redirect()->route('logs.index')
        ->with('success', 'Log entry updated successfully!');
}

    public function destroy(LogEntry $log)
    {
        Log::info('Attempting to delete log entry');

        // Ensure user can only delete their own logs
        if ($log->user_id !== Auth::id()) {
            Log::error('Unauthorized delete attempt');

            abort(403, 'Unauthorized action.');
        }

        $log->delete();

        Log::info('Log entry deleted successfully');

        return redirect()->route('logs.index')->with('success', 'Log entry deleted successfully!');
    }
}
