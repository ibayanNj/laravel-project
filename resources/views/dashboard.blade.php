@extends('layouts.app')

@section('title', 'Dashboard - Internship Log Book')

@section('content')

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4">

            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div class="mb-6 p-3 rounded bg-green-100 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-3 rounded bg-red-100 text-red-800 text-sm">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- HEADER --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Hello, {{ auth()->user()->name }}</h1>
                        <p class="text-gray-600 text-sm mt-1">Track your internship progress</p>
                    </div>

                    <!-- Grouped buttons with minimal gap -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('logs.index') }}"
                            class="px-4 py-2 rounded bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium transition">
                            Logs
                        </a>

                        <a href="{{ route('logs.create') }}"
                            class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                            + New Entry
                        </a>
                    </div>
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="p-4 bg-white rounded border">
                    <p class="text-gray-600 text-xs">Total Entries</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $logs->count() }}</p>
                </div>
                <div class="p-4 bg-white rounded border">
                    <p class="text-gray-600 text-xs">Total Hours</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $logs->sum('hours_worked') }}</p>
                </div>
                <div class="p-4 bg-white rounded border">
                    <p class="text-gray-600 text-xs">Average</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ $logs->count() > 0 ? number_format($logs->sum('hours_worked') / $logs->count(), 1) : '0' }}
                    </p>
                </div>
                <div class="p-4 bg-white rounded border">
                    <p class="text-gray-600 text-xs">Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $logs->where('status', 'pending')->count() }}</p>
                </div>
            </div>

            {{-- RECENT LOGS --}}
            <div class="bg-white rounded border">
                <div class="p-4 border-b flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Recent Activity</h2>
                    @if ($logs->count() > 5)
                        <a href="{{ route('logs.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                            View all →
                        </a>
                    @endif
                </div>

                <div class="p-4">
                    @if ($logs->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-4xl mb-2">📄</p>
                            <h3 class="font-semibold text-gray-900 mb-1">No entries yet</h3>
                            <p class="text-gray-600 text-sm mb-4">Start logging your internship</p>
                            <a href="{{ route('logs.create') }}"
                                class="inline-block px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm">
                                + Add Entry
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($logs->take(5) as $log)
                                <div class="flex gap-4 pb-4 border-b last:border-0">
                                    <div class="shrink-0 w-16 text-center p-2 bg-gray-100 rounded">
                                        <div class="text-2xl font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($log->date)->format('d') }}
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            {{ \Carbon\Carbon::parse($log->date)->format('M') }}
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs text-gray-600">{{ $log->hours_worked }}h worked</span>
                                            @if ($log->status === 'approved')
                                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded">✓
                                                    Approved</span>
                                            @elseif($log->status === 'rejected')
                                                <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded">✗
                                                    Rejected</span>
                                            @else
                                                <span
                                                    class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs rounded">Pending</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-900 mb-2">{{ Str::limit($log->tasks, 100) }}</p>
                                        <div class="flex flex-wrap gap-1">
                                            @if ($log->skills)
                                                <span
                                                    class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded">{{ $log->skills }}</span>
                                            @endif
                                            @if ($log->challenges)
                                                <span
                                                    class="px-2 py-0.5 bg-orange-50 text-orange-700 text-xs rounded">Challenge</span>
                                            @endif
                                            @if ($log->learnings)
                                                <span
                                                    class="px-2 py-0.5 bg-purple-50 text-purple-700 text-xs rounded">Learning</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($logs->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('logs.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                                    View all {{ $logs->count() }} entries →
                                </a>
                            </div>
                        @endif


                        {{-- Add to dashboard.blade.php or any view --}}

                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection
