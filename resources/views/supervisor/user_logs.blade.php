@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-1 h-10 bg-indigo-600 rounded-full"></div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Log Entries</h2>
                            <p class="text-lg text-gray-600 mt-1">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('supervisor.index') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Hours</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Tasks</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Skills</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Challenges</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Learnings</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($entries as $entry)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            {{ \Carbon\Carbon::parse($entry->date)->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $entry->hours_worked }}h
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-800 max-w-xs">
                                        <p class="line-clamp-3">{{ $entry->tasks }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-800 max-w-xs">
                                        <p class="line-clamp-3">{{ $entry->skills }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-800 max-w-xs">
                                        <p class="line-clamp-3">{{ $entry->challenges }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-gray-800 max-w-xs">
                                        <p class="line-clamp-3">{{ $entry->learnings }}</p>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @switch($entry->status)
                                            @case('approved')
                                                <span
                                                    class="inline-flex items-center px-4 py-2 text-xs font-bold text-green-800 bg-green-100 rounded-full">
                                                    Approved
                                                </span>
                                            @break

                                            @case('rejected')
                                                <span
                                                    class="inline-flex items-center px-4 py-2 text-xs font-bold text-red-800 bg-red-100 rounded-full">
                                                    Rejected
                                                </span>
                                            @break

                                            @default
                                                <!-- Pending: Show action buttons -->
                                                <!-- <div class="flex justify-center gap-2">
                                                                                        <form action="{{ route('supervisor.log.approve', $entry->id) }}" method="POST"
                                                                                            class="inline">
                                                                                            @csrf @method('POST')
                                                                                            <button class="btn-approve-sm">Approve</button>
                                                                                        </form>
                                                                                        <form action="{{ route('supervisor.log.reject', $entry->id) }}" method="POST"
                                                                                            class="inline">
                                                                                            @csrf @method('POST')
                                                                                            <button onclick="return confirm('Reject this entry?')"
                                                                                                class="btn-reject-sm">Reject</button>
                                                                                        </form>
                                                                                    </div> -->

                                                <div class="flex justify-center gap-2">
                                                    <form action="{{ route('supervisor.log.approve', $entry->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf @method('POST')
                                                        <button
                                                            class="px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-md 
           hover:bg-green-700 active:bg-green-800 transition-colors duration-200 
           shadow-sm hover:shadow-md">
                                                            Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('supervisor.log.reject', $entry->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf @method('POST')
                                                        <button onclick="return confirm('Reject this entry?')"
                                                            class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 active:bg-red-700 transition-colors duration-200 shadow-sm hover:shadow-md">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                        @endswitch
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            No log entries found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
