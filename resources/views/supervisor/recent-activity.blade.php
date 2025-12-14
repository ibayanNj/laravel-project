@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">

      {{-- HEADER --}}
      <header class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Recent Activity</h1>
            <p class="text-gray-600 text-sm mt-1">Monitor all intern log entries in real-time</p>
          </div>
          
          <nav class="flex items-center gap-2">
            <a href="{{ route('supervisor.index') }}"
              class="px-4 py-2 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium transition-colors">
              ← Dashboard
            </a>
          </nav>
        </div>
      </header>

      {{-- FILTERS --}}
      <div class="mb-6 bg-white p-4 rounded-lg border">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
          <div class="flex-1 min-w-50">
            <label class="block text-xs font-medium text-gray-700 mb-1">Filter by Status</label>
            <select name="status" 
              class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">All Statuses</option>
              <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
              <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
          </div>

          <div class="flex-1 min-w-50]">
            <label class="block text-xs font-medium text-gray-700 mb-1">Filter by Intern</label>
            <select name="user_id" 
              class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">All Interns</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="flex gap-2">
            <button type="submit" 
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
              Apply Filters
            </button>
            @if(request()->hasAny(['status', 'user_id']))
              <a href="{{ route('supervisor.recent-activity') }}" 
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                Clear
              </a>
            @endif
          </div>
        </form>
      </div>


      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="p-4 bg-white rounded-lg border">
          <p class="text-gray-600 text-xs">Total Logs Today</p>
          <p class="text-3xl font-bold text-gray-900 mt-1">{{ $todayCount }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg border">
          <p class="text-gray-600 text-xs">Pending Review</p>
          <p class="text-3xl font-bold text-yellow-400 mt-1">{{ $pendingCount }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg border">
          <p class="text-gray-600 text-xs">Total Hours (Today)</p>
          <p class="text-3xl font-bold text-gray-900 mt-1">{{ $todayHours }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg border">
          <p class="text-gray-600 text-xs">Active Interns</p>
          <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeInterns }}</p>
        </div>
      </div>

      <section class="bg-white rounded-lg border">
        <div class="p-4 border-b">
          <div class="flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Recent Log Entries</h2>
            <span class="text-xs text-gray-500">{{ $logs->total() }} total entries</span>
          </div>
        </div>

        <div class="divide-y">
          @forelse($logs as $log)
            <article class="p-4 hover:bg-gray-50 transition-colors">
              <div class="flex gap-4">
                

                <a href="{{ route('supervisor.user.logs', $log->user_id) }}" 
                  class="shrink-0 w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm hover:bg-blue-700 transition-colors"
                  title="View {{ $log->user->name }}'s logs">
                  {{ strtoupper(substr($log->user->name, 0, 2)) }}
                </a>


                <div class="flex-1 min-w-0">
                  

                  <div class="flex items-start justify-between gap-2 mb-2">
                    <div>
                      <a href="{{ route('supervisor.user.logs', $log->user_id) }}" 
                        class="font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                        {{ $log->user->name }}
                      </a>
                      <span class="text-gray-500 text-sm"> added a new log entry</span>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                      {{-- Status Badge --}}
                      @if ($log->status === 'approved')
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                          ✓ Approved
                        </span>
                      @elseif($log->status === 'rejected')
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                          ✗ Rejected
                        </span>
                      @else
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                          ⏳ Pending
                        </span>
                      @endif
                    </div>
                  </div>


                  <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
                    <span class="flex items-center gap-1">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      <time datetime="{{ $log->date }}">{{ \Carbon\Carbon::parse($log->date)->format('M d, Y') }}</time>
                    </span>
                    <span class="flex items-center gap-1">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      {{ $log->hours_worked }}h worked
                    </span>
                    <span class="flex items-center gap-1 text-gray-400">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      {{ $log->created_at->diffForHumans() }}
                    </span>
                  </div>


                  <p class="text-sm text-gray-700 mb-3 line-clamp-2">
                    {{ $log->tasks }}
                  </p>


                  @if ($log->skills || $log->challenges || $log->learnings)
                    <div class="flex flex-wrap gap-1.5 mb-3">
                      @if ($log->skills)
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md font-medium">
                          💡 {{ Str::limit($log->skills, 40) }}
                        </span>
                      @endif
                      @if ($log->challenges)
                        <span class="px-2 py-1 bg-orange-50 text-orange-700 text-xs rounded-md font-medium">
                          ⚠️ {{ Str::limit($log->challenges, 40) }}
                        </span>
                      @endif
                      @if ($log->learnings)
                        <span class="px-2 py-1 bg-purple-50 text-purple-700 text-xs rounded-md font-medium">
                          📚 {{ Str::limit($log->learnings, 40) }}
                        </span>
                      @endif
                    </div>
                  @endif

                  @if($log->status === 'pending')
                    <div class="flex gap-2">
                      <form method="POST" action="{{ route('supervisor.logs.approve', $log->id) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                          class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors">
                          ✓ Approve
                        </button>
                      </form>
                      
                      <form method="POST" action="{{ route('supervisor.logs.reject', $log->id) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                          class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-colors">
                          ✗ Reject
                        </button>
                      </form>

                      <a href="{{ route('supervisor.user.logs', $log->user_id) }}" 
                        class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition-colors">
                        View Details
                      </a>
                    </div>
                  @else
                    <a href="{{ route('supervisor.user.logs', $log->user_id) }}" 
                      class="inline-block px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition-colors">
                      View Details
                    </a>
                  @endif
                </div>
              </div>
            </article>

          @empty
            <div class="text-center py-16">
              <p class="text-4xl mb-3" aria-hidden="true">📋</p>
              <h3 class="font-semibold text-gray-900 mb-1">No log entries found</h3>
              <p class="text-gray-600 text-sm mb-4">
                @if(request()->hasAny(['status', 'user_id']))
                  Try adjusting your filters to see more results
                @else
                  Interns haven't submitted any logs yet
                @endif
              </p>
              @if(request()->hasAny(['status', 'user_id']))
                <a href="{{ route('supervisor.recent-activity') }}" 
                  class="inline-block px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm transition-colors">
                  Clear Filters
                </a>
              @endif
            </div>
          @endforelse
        </div>


        @if($logs->hasPages())
          <div class="p-4 border-t">
            {{ $logs->links() }}
          </div>
        @endif
      </section>

    </div>
  </div>
@endsection