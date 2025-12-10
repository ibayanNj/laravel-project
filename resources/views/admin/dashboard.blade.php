@extends('layouts.app')

@section('title', 'Admin Dashboard')

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
                    <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-gray-600 text-sm mt-1">Manage users</p>
                </div>
                <a href="{{ route('admin.users') }}"
                    class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                    Manage Users
                </a>
            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="p-4 bg-white rounded border">
                <p class="text-gray-600 text-xs">Interns</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUsers }}</p>
            </div>
            <div class="p-4 bg-white rounded border">
                <p class="text-gray-600 text-xs">Supervisors</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalSupervisors }}</p>
            </div>
            <div class="p-4 bg-white rounded border">
                <p class="text-gray-600 text-xs">Administrators</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalAdmins }}</p>
            </div>
        </div>

    </div>
</div>

@endsection