@extends('layouts.app')

@section('title', 'All Logs - Internship Log Book')

@push('scripts')
    <script src="{{ asset('js/logs-table-filter.js') }}"></script>
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-6xl px-4">
            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 p-4 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 p-4 text-sm text-red-800">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- HEADER --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">All Log Entries</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $logs->count() }} entries • {{ $logs->sum('hours_worked') }} hours total
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('logs.weekly') }}"
                        class="rounded-lg border bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        📅 Weekly View
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-lg border bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Dashboard
                    </a>
                    <a href="{{ route('logs.create') }}"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                        + New Entry
                    </a>
                </div>
            </div>

            {{-- FILTERS --}}
            <div class="mb-6 rounded-lg border bg-white p-4 shadow-sm">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <input type="text" id="searchInput" placeholder="Search entries..."
                        class="rounded-lg border px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                    <select id="statusFilter"
                        class="rounded-lg border px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">All Status</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>

                    <select id="sortBy"
                        class="rounded-lg border px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="date-desc">Latest First</option>
                        <option value="date-asc">Oldest First</option>
                        <option value="hours-desc">Most Hours</option>
                        <option value="hours-asc">Least Hours</option>
                    </select>
                </div>
            </div>

            {{-- EMPTY STATE --}}

            @if ($logs->isEmpty())
                <div class="rounded-lg border bg-white py-16 text-center shadow-sm">
                    <p class="mb-4 text-6xl">Empty Log Book</p>
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">No entries yet</h3>
                    <p class="mb-6 text-gray-600">Start documenting your internship journey</p>
                    <a href="{{ route('logs.create') }}"
                        class="inline-block rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700">
                        + Create First Entry
                    </a>
                </div>
            @else
                {{-- TABLE CARD --}}
                <div class="overflow-hidden rounded-lg border bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="logsTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Hours
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Tasks
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Skills
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Challenges
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Learnings
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Status
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($logs as $log)
                                    <tr class="log-row transition hover:bg-gray-50" data-date="{{ $log->date }}"
                                        data-hours="{{ $log->hours_worked }}" data-status="{{ $log->status }}"></tr>

                                    <tr class="log-row border-b border-gray-100 bg-white transition-all duration-200 hover:bg-gray-50/70"
                                        data-date="{{ $log->date }}" data-hours="{{ $log->hours_worked }}"
                                        data-status="{{ $log->status }}">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($log->date)->format('M j, Y') }}
                                            </div>
                                            <div class="mt-0.5 text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($log->date)->format('l') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span
                                                class="inline-flex rounded-full bg-indigo-100 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                                                {{ $log->hours_worked }}h
                                            </span>
                                        </td>

                                        <td class="max-w-xs px-6 py-5 text-sm text-gray-800">
                                            <div class="rounded-lg bg-gray-50/80 px-4 py-3 leading-relaxed text-gray-900">
                                                {{ Str::limit($log->tasks, 100) }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-5 text-center whitespace-nowrap">
                                            @if ($log->skills)
                                                <span
                                                    class="inline-flex rounded-full bg-green-100 px-3 py-1.5 text-xs font-medium text-green-700">
                                                    {{ Str::limit($log->skills, 20) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">—</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-5 text-center whitespace-nowrap">
                                            @if ($log->challenges)
                                                <span
                                                    class="inline-flex rounded-full bg-orange-100 px-3 py-1.5 text-xs font-medium text-orange-700">
                                                    {{ Str::limit($log->challenges, 20) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">—</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-5 text-center whitespace-nowrap">
                                            @if ($log->learnings)
                                                <span
                                                    class="inline-flex rounded-full bg-purple-100 px-3 py-1.5 text-xs font-medium text-purple-700">
                                                    {{ Str::limit($log->learnings, 20) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">—</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-5 text-center whitespace-nowrap">
                                            @if ($log->status === 'approved')
                                                <span
                                                    class="inline-flex rounded-full bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-700">
                                                    Approved
                                                </span>
                                            @elseif ($log->status === 'rejected')
                                                <span
                                                    class="inline-flex rounded-full bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700">
                                                    Rejected
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex rounded-full bg-yellow-100 px-3 py-1.5 text-xs font-semibold text-yellow-700">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER COUNT --}}
                    <div class="border-t border-gray-200 bg-gray-50 px-6 py-3 text-center text-sm text-gray-600">
                        Showing
                        <span id="displayedCount">{{ $logs->count() }}</span>
                        of
                        <span id="totalCount">{{ $logs->count() }}</span>
                        entries
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
