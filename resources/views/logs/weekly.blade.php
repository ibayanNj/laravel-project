@extends('layouts.app')

@section('title', 'Weekly Logs - Internship Log Book')

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
          <h1 class="text-2xl font-bold text-gray-900">Weekly Log Entries</h1>
          <p class="mt-1 text-sm text-gray-600">
            Organized by week
          </p>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('logs.index') }}"
            class="rounded-lg border bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
            📋 All Logs
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

      {{-- WEEKLY DATA --}}
      @forelse($weeklyData as $week)
        <div class="mb-6 overflow-hidden rounded-lg border bg-white shadow-sm">
          {{-- Week Header --}}
          <div class="border-b bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $week['week_label'] }}</h3>
                <p class="mt-0.5 text-sm text-gray-500">
                  <span
                    class="inline-flex items-center rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800">
                    Week {{ $week['week_number'] }}
                  </span>
                </p>
              </div>
              <div class="text-right">
                <p class="text-3xl font-bold text-blue-600">
                  {{ $week['total_hours'] }}<span class="text-xl text-gray-500">h</span>
                </p>
                <p class="mt-1 text-xs text-gray-500">
                  {{ $week['entry_count'] }} {{ Str::plural('entry', $week['entry_count']) }}
                </p>
              </div>
            </div>
          </div>

          {{-- Table --}}
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                    Date
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                    Tasks
                  </th>
                  <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                    Hours
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($week['logs'] as $log)
                  <tr class="transition-all duration-200 hover:bg-gray-50/70">
                    <td class="whitespace-nowrap px-6 py-4">
                      <span
                        class="inline-flex items-center rounded-md border border-gray-200 bg-gray-100 px-2.5 py-1 text-sm font-semibold text-gray-700">
                        {{ $log['date_formatted'] }}
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      <p class="text-sm leading-relaxed text-gray-600">{{ $log['tasks'] }}</p>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-right">
                      <span
                        class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-bold text-blue-700">
                        {{ $log['hours_worked'] }}h
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @empty
        {{-- EMPTY STATE --}}
        <div class="rounded-lg border bg-white py-16 text-center shadow-sm">
          <p class="mb-4 text-6xl">📅</p>
          <h3 class="mb-2 text-xl font-semibold text-gray-900">No weekly data yet</h3>
          <p class="mb-6 text-gray-600">Start logging your internship activities</p>
          <a href="{{ route('logs.create') }}"
            class="inline-block rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700">
            + Create First Entry
          </a>
        </div>
      @endforelse
    </div>
  </div>
@endsection
