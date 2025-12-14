@extends('layouts.app')

@section('title', 'Dashboard - Internship Log Book')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4">

      {{-- FLASH MESSAGES --}}
      @if (session('success'))
        <div class="mb-6 p-3 rounded bg-green-100 text-green-800 text-sm" role="alert">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-6 p-3 rounded bg-red-100 text-red-800 text-sm" role="alert">
          <ul class="space-y-1">
            @foreach ($errors->all() as $error)
              <li>• {{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- HEADER --}}
      <header class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Hello, {{ auth()->user()->name }}</h1>
            <p class="text-gray-600 text-sm mt-1">Track your internship progress</p>
          </div>

          <nav class="flex items-center gap-2">
            <a href="{{ route('logs.index') }}"
              class="px-4 py-2 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium transition-colors">
              Logs
            </a>
            <a href="{{ route('logs.create') }}"
              class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition-colors">
              + New Entry
            </a>
          </nav>
        </div>
      </header>

      {{-- STATS --}}
      @php
        $totalEntries = $logs->count();
        $totalHours = $logs->sum('hours_worked');
        $avgHours = $totalEntries > 0 ? number_format($totalHours / $totalEntries, 1) : '0';
        $pendingCount = $logs->where('status', 'pending')->count();
      @endphp

      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="p-4 bg-white rounded border">
          <p class="text-gray-600 text-xs">Total Entries</p>
          <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalEntries }}</p>
        </div>
        <div class="p-4 bg-white rounded border">
          <p class="text-gray-600 text-xs">Total Hours</p>
          <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalHours }}</p>
        </div>
        <div class="p-4 bg-white rounded border">
          <p class="text-gray-600 text-xs">Average Hours</p>
          <p class="text-3xl font-bold text-gray-900 mt-1">{{ $avgHours }}</p>
        </div>
        <div class="p-4 bg-white rounded border">
          <p class="text-gray-600 text-xs">Pending Approval</p>
          <p class="text-3xl font-bold text-gray-900 mt-1">{{ $pendingCount }}</p>
        </div>
      </div>

      {{-- RECENT ACTIVITY --}}
      <section class="bg-white rounded border" x-data="{ showAll: false }">
        <div class="p-4 border-b flex items-center justify-between">
          <h2 class="font-semibold text-gray-900">Recent Activity</h2>
          @if ($totalEntries > 5)
            <button @click="showAll = !showAll" 
              class="text-sm text-blue-600 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-2 py-1"
              type="button">
              <span x-show="!showAll">View all {{ $totalEntries }} →</span>
              <span x-show="showAll" x-cloak>Show less ←</span>
            </button>
          @endif
        </div>

        <div class="p-4">
          @forelse ($logs as $index => $log)
            @if ($index === 0)
              <div class="space-y-4">
            @endif

            <article 
              x-show="showAll || {{ $index }} < 5" 
              x-transition
              class="flex gap-4 pb-4 border-b last:border-0">

              {{-- Date Badge --}}
              <div class="shrink-0 w-16 rounded bg-gray-100 p-2 text-center">
                <time datetime="{{ $log->date }}" class="text-2xl font-bold text-gray-900 block">
                  {{ \Carbon\Carbon::parse($log->date)->format('d') }}
                </time>
                <span class="text-xs text-gray-600">
                  {{ \Carbon\Carbon::parse($log->date)->format('M') }}
                </span>
              </div>

              {{-- Content --}}
              <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2 mb-2">
                  <span class="text-xs text-gray-600 whitespace-nowrap">
                    {{ $log->hours_worked }}h worked
                  </span>

                  {{-- Status Badge --}}
                  @if ($log->status === 'approved')
                    <span class="rounded bg-green-100 px-2 py-0.5 text-xs text-green-700 whitespace-nowrap">
                      ✓ Approved
                    </span>
                  @elseif($log->status === 'rejected')
                    <span class="rounded bg-red-100 px-2 py-0.5 text-xs text-red-700 whitespace-nowrap">
                      ✗ Rejected
                    </span>
                  @else
                    <span class="rounded bg-yellow-100 px-2 py-0.5 text-xs text-yellow-700 whitespace-nowrap">
                      ⏳ Pending
                    </span>
                  @endif
                </div>

                <p class="mb-2 text-sm text-gray-900 line-clamp-2">
                  {{ $log->tasks }}
                </p>

                {{-- Tags --}}
                @if ($log->skills || $log->challenges || $log->learnings)
                  <div class="flex flex-wrap gap-1">
                    @if ($log->skills)
                      <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded" title="Skills">
                        {{ Str::limit($log->skills, 30) }}
                      </span>
                    @endif
                    @if ($log->challenges)
                      <span class="px-2 py-0.5 bg-orange-50 text-orange-700 text-xs rounded" title="Challenges">
                        {{ Str::limit($log->challenges, 30) }}
                      </span>
                    @endif
                    @if ($log->learnings)
                      <span class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs rounded" title="Learnings">
                        {{ Str::limit($log->learnings, 30) }}
                      </span>
                    @endif
                  </div>
                @endif
              </div>
            </article>

            @if ($loop->last)
              </div>
              @if ($totalEntries > 5)
                <div class="mt-4 text-center">
                  <button @click="showAll = !showAll" 
                    class="text-sm text-blue-600 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-2 py-1"
                    type="button">
                    <span x-show="!showAll">View all {{ $totalEntries }} entries →</span>
                    <span x-show="showAll" x-cloak>Show less ←</span>
                  </button>
                </div>
              @endif
            @endif

          @empty
            <div class="text-center py-12">
              <p class="text-4xl mb-2" aria-hidden="true">📄</p>
              <h3 class="font-semibold text-gray-900 mb-1">No entries yet</h3>
              <p class="text-gray-600 text-sm mb-4">Start logging your internship</p>
              <a href="{{ route('logs.create') }}"
                class="inline-block px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm transition-colors">
                + Add Entry
              </a>
            </div>
          @endforelse
        </div>
      </section>
    </div>
  </div>
@endsection