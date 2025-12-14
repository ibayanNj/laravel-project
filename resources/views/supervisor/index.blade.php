@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">

      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-extrablack text-gray-900">Supervisor Dashboard</h1>
            <p class="text-gray-600 text-sm mt-1">View user logs and monitor internship progress</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="p-6 bg-white rounded-xl border shadow-sm hover:shadow-md transition-shadow">
          <div class="flex flex-col items-center justify-center text-center space-y-3">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
              Total Interns
            </p>
            <p
              class="font-bold text-blue-500 leading-none text-4xl sm:text-5xl lg:text-6xl xl:text-7xl {{ $users->count() >= 1000 ? 'text-5xl sm:text-6xl lg:text-7xl' : '' }}">
              {{ $users->count() }}
            </p>
            <p class="text-xs text-gray-400">
              Active users
            </p>
          </div>
        </div>


       <div class="p-6 bg-white rounded-xl border shadow-sm hover:shadow-md transition-shadow">
          <div class="flex flex-col items-center justify-center text-center space-y-3 h-full">
            <div>
              <h3 class="font-bold text-blue-400 leading-none text-4xl sm:text-3xl lg:text-3xl xl:text-3xl">Recent Activity</h3>
            </div>
            <a href="{{ route('supervisor.recent-activity') }}"
              class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-white text-blue-600 hover:bg-blue-50 text-sm font-semibold transition-colors shadow-sm mt-2">
              View Activity
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
              </svg>
            </a>
          </div>
        </div>
      </div>





      <br>
      <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-1">Interns</h2>
        <p class="text-gray-600 text-sm">Click on any user to view their detailed activity logs</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($users as $user)
          <a href="{{ route('supervisor.user.logs', $user->id) }}"
            class="block bg-white p-6 rounded border hover:border-blue-600 hover:shadow-md transition">
            <div class="flex flex-col items-center text-center">
              <!-- Avatar -->
              <div
                class="w-16 h-16 rounded-full border-2 border-gray-300 flex items-center justify-center 
                                    text-lg font-bold text-white bg-blue-600 mb-4">
                {{ strtoupper(substr($user->name, 0, 2)) }}
              </div>

              <!-- User Info -->
              <h3 class="text-gray-900 font-semibold text-base mb-1">
                {{ $user->name }}
              </h3>

              <p class="text-gray-500 text-xs font-medium uppercase tracking-wide">View Logs</p>
            </div>
          </a>
        @endforeach
      </div>

    </div>
  </div>
@endsection
