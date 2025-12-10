<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Log;

class SupervisorController extends Controller
{
    // Show list of all users
    public function index()
    {
        Log::info('Supervisor accessing users list', [
            'supervisor_id' => auth()->id()
        ]);

        $users = User::where('role', 'user')->get();

        Log::info('Supervisor users list loaded');

        return view('supervisor.index', compact('users'));
    }

    // Show log entries for a specific user
    public function showUserLogs($id)
    {
        Log::info('Supervisor accessing user logs');

        $user = User::findOrFail($id);
        $entries = LogEntry::where('user_id', $user->id)->get();

        Log::info('User logs loaded by supervisor');


        return view('supervisor.user_logs', compact('user', 'entries'));
    }

    // CREATE – Show form
    public function createLog($user_id)
    {
        Log::info('Supervisor accessing create log form');

        $user = User::findOrFail($user_id);
        return view('supervisor.logs.create', compact('user'));
    }

    // STORE – Save to database
    public function storeLog(Request $request, $user_id)
    {
        Log::info('Supervisor attempting to create log entry');

        $request->validate([
            'date' => 'required|date',
            'activity' => 'required|string|max:255',
            'hours' => 'required|numeric|min:1',
        ]);

        $logEntry = LogEntry::create([
            'user_id' => $user_id,
            'date' => $request->date,
            'activity' => $request->activity,
            'hours' => $request->hours,
        ]);

        Log::info('Log entry created by supervisor');

        return redirect()->route('supervisor.user.logs', $user_id)
            ->with('success', 'Log entry created successfully!');
    }

    // EDIT – Show form to edit log
    public function editLog($id)
    {
        Log::info('Supervisor accessing edit log form');

        $entry = LogEntry::findOrFail($id);
        return view('supervisor.logs.edit', compact('entry'));
    }

    // UPDATE – Save edits
    public function updateLog(Request $request, $id)
    {
        Log::info('Supervisor attempting to update log entry');

        $request->validate([
            'date' => 'required|date',
            'activity' => 'required|string|max:255',
            'hours' => 'required|numeric|min:1',
        ]);

        $entry = LogEntry::findOrFail($id);

        $entry->update([
            'date' => $request->date,
            'activity' => $request->activity,
            'hours' => $request->hours,
        ]);

        Log::info('Log entry updated by supervisor');

        return redirect()->route('supervisor.user.logs', $entry->user_id)
            ->with('success', 'Log entry updated successfully!');
    }

    // DELETE – Remove log entry
    public function deleteLog($id)
    {
        Log::info('Supervisor attempting to delete log entry');

        $entry = LogEntry::findOrFail($id);
        $userId = $entry->user_id;

        $entry->delete();

        Log::info('Log entry deleted by supervisor');

        return redirect()->route('supervisor.user.logs', $userId)
            ->with('success', 'Log entry deleted successfully!');
    }

    // APPROVE – Approve a log entry
    public function approve($id)
    {
        Log::info('Supervisor attempting to approve log entry');

        $entry = LogEntry::findOrFail($id);
        $entry->status = 'approved';
        $entry->save();

        Log::info('Log entry approved by supervisor');

        return redirect()->back()->with('success', 'Entry approved successfully!');
    }

    public function reject($id)
    {
        Log::info('Supervisor attempting to reject log entry');

        $entry = LogEntry::findOrFail($id);
        $entry->status = 'rejected';
        $entry->save();

        Log::info('Log entry rejected by supervisor');

        return redirect()->back()->with('success', 'Entry rejected successfully!');
    }

    // PENDING – Reset to pending status
    public function resetToPending($id)
    {
        Log::info('Supervisor attempting to reset log entry to pending');

        $entry = LogEntry::findOrFail($id);

        $entry->update([
            'status' => 'pending',
            'approved_at' => null,
            'rejected_at' => null,
        ]);

        Log::info('Log entry reset to pending by supervisor');

        return redirect()->back()->with('success', 'Log entry reset to pending!');
    }
}
