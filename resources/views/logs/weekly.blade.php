@extends('layouts.app')

@section('title', 'Weekly Logs - Internship Log Book')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header with Back Button -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-150 border border-gray-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Weekly Logs</h2>
    </div>

    @foreach($weeklyData as $week)
    <div class="mb-8 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <!-- Week Header -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-semibold text-lg text-gray-900">{{ $week['week_label'] }}</h3>
                    <p class="text-sm text-gray-500 mt-0.5">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            Week {{ $week['week_number'] }}
                        </span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-blue-600">{{ $week['total_hours'] }}<span class="text-xl text-gray-500">h</span></p>
                    <p class="text-xs text-gray-500 mt-1">{{ $week['entry_count'] }} {{ Str::plural('entry', $week['entry_count']) }}</p>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tasks
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hours
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($week['logs'] as $log)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-semibold bg-gray-100 border border-gray-200 text-gray-700">
                                {{ $log['date_formatted'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $log['tasks'] }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-700">
                                {{ $log['hours_worked'] }}h
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection