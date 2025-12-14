<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SupervisorController extends Controller
{
    // Show list of all users
    public function index()
    {
        Log::info('Supervisor accessing users list');

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

        return redirect()->route('supervisor.user.logs', $user_id)->with('success', 'Log entry created successfully!');
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

        return redirect()->route('supervisor.user.logs', $entry->user_id)->with('success', 'Log entry updated successfully!');
    }

    // DELETE – Remove log entry
    // public function deleteLog($id)
    // {
    //     Log::info('Supervisor attempting to delete log entry');

    //     $entry = LogEntry::findOrFail($id);
    //     $userId = $entry->user_id;

    //     $entry->delete();

    //     Log::info('Log entry deleted by supervisor');

    //     return redirect()->route('supervisor.user.logs', $userId)->with('success', 'Log entry deleted successfully!');
    // }

    // APPROVE – Approve a log entry with optional remarks
    // public function approve(Request $request, $id)
    // {
    //     Log::info('Supervisor attempting to approve log entry');

    //     $request->validate([
    //         'remarks' => 'nullable|string|max:1000',
    //     ]);

    //     $entry = LogEntry::findOrFail($id);
    //     $entry->status = 'approved';
    //     $entry->remarks = $request->remarks;
    //     $entry->save();

    //     Log::info('Log entry approved by supervisor', ['remarks' => $request->remarks]);

    //     return redirect()->back()->with('success', 'Entry approved successfully!');
    // }

    // // REJECT – Reject a log entry with optional remarks
    // public function reject(Request $request, $id)
    // {
    //     Log::info('Supervisor attempting to reject log entry');

    //     $request->validate([
    //         'remarks' => 'nullable|string|max:1000',
    //     ]);

    //     $entry = LogEntry::findOrFail($id);
    //     $entry->status = 'rejected';
    //     $entry->remarks = $request->remarks;
    //     $entry->save();

    //     Log::info('Log entry rejected by supervisor', ['remarks' => $request->remarks]);

    //     return redirect()->back()->with('success', 'Entry rejected successfully!');
    // }

//     public function updateRemarks(Request $request, LogEntry $entry)
// {
//     $request->validate([
//         'remarks' => 'nullable|string|max:1000',
//     ]);

//     $entry->update([
//         'remarks' => $request->input('remarks'),
//     ]);

//     Log::info('Remarks updated by supervisor', [
//         'entry_id' => $entry->id,
//         'remarks' => $request->input('remarks')
//     ]);

//     return redirect()->back()->with('success', 'Remarks updated successfully!');
// }

// public function destroy(LogEntry $entry)
// {
//     Log::info('Supervisor attempting to delete log entry', ['entry_id' => $entry->id]);

//     $entry->delete();

//     Log::info('Log entry deleted by supervisor', ['entry_id' => $entry->id]);

//     return redirect()->back()->with('success', 'Log entry deleted successfully!');
// }


public function deleteLog($id)
{
    try {
        $entry = LogEntry::findOrFail($id);
        
        Log::info('Supervisor deleting log entry', [
            'entry_id' => $entry->id,
            'user_id' => $entry->user_id,
            'supervisor_id' => auth()->id()
        ]);
        
        $entry->delete();
        
        Log::info('Log entry deleted successfully', ['entry_id' => $id]);
        
        return redirect()->back()->with('success', 'Log entry deleted successfully!');
        
    } catch (\Exception $e) {
        Log::error('Error deleting log entry', [
            'entry_id' => $id,
            'error' => $e->getMessage()
        ]);
        
        return redirect()->back()->with('error', 'Failed to delete log entry. Please try again.');
    }
}





    // APPROVE – Approve a log entry with optional remarks
// public function approve(Request $request, LogEntry $entry)
// {
//     Log::info('Supervisor attempting to approve log entry', ['entry_id' => $entry->id]);

//     $request->validate([
//         'remarks' => 'nullable|string|max:1000',
//     ]);

//     $entry->update([
//         'status' => 'approved',
//         'remarks' => $request->input('remarks'),
//     ]);

//     Log::info('Log entry approved by supervisor', [
//         'entry_id' => $entry->id,
//         'remarks' => $request->input('remarks')
//     ]);

//     return redirect()->back()->with('success', 'Entry approved successfully!');
// }

// REJECT – Reject a log entry with optional remarks
// public function reject(Request $request, LogEntry $entry)
// {
//     Log::info('Supervisor attempting to reject log entry', ['entry_id' => $entry->id]);

//     $request->validate([
//         'remarks' => 'nullable|string|max:1000',
//     ]);

//     $entry->update([
//         'status' => 'rejected',
//         'remarks' => $request->input('remarks'),
//     ]);

//     Log::info('Log entry rejected by supervisor', [
//         'entry_id' => $entry->id,
//         'remarks' => $request->input('remarks')
//     ]);

//     return redirect()->back()->with('success', 'Entry rejected successfully!');
// }



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


        public function recentActivity(Request $request)
    {
        // Get all users (interns) for the filter dropdown
        $users = User::where('role', 'intern')
            ->orderBy('name')
            ->get();

        // Build the query
        $query = LogEntry::with('user')
            ->latest('created_at');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Get paginated logs
        $logs = $query->paginate(20)->withQueryString();

        // Calculate stats
        $todayCount = LogEntry::whereDate('created_at', Carbon::today())->count();
        $pendingCount = LogEntry::where('status', 'pending')->count();
        $todayHours = LogEntry::whereDate('created_at', Carbon::today())->sum('hours_worked');
        $activeInterns = LogEntry::whereDate('created_at', Carbon::today())
            ->distinct('user_id')
            ->count('user_id');

        return view('supervisor.recent-activity', compact(
            'logs',
            'users',
            'todayCount',
            'pendingCount',
            'todayHours',
            'activeInterns'
        ));
    }

}
