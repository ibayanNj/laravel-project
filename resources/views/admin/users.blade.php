@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')

  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      {{-- Header --}}
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Manage Users</h1>
          <p class="text-gray-600 mt-1">Add, edit, or remove users from the system</p>
        </div>

        <div class="mt-4 sm:mt-0 flex gap-2">
          <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white font-medium rounded-lg transition">
            Back
          </a>
          <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add New User
          </a>
        </div>
      </div>

      {{-- Success/Error Messages --}}
      @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
          {{ session('error') }}
        </div>
      @endif

      {{-- Users Table --}}
      <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($users as $user)
                <tr class="{{ $user->trashed() ? 'bg-gray-50 opacity-60' : 'hover:bg-gray-50' }}">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="h-10 w-10 shrink-0">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                          <span class="text-indigo-600 font-semibold text-sm">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                          </span>
                        </div>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        @if ($user->id === auth()->id())
                          <span class="text-xs text-indigo-600 font-medium">(You)</span>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if ($user->role === 'admin')
                      <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-600">
                        Admin
                      </span>
                    @elseif($user->role === 'supervisor')
                      <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full text-purple-600 bg-purple-100">
                        Supervisor
                      </span>
                    @else
                      <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                        Intern
                      </span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if ($user->trashed())
                      <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Deleted
                      </span>
                    @else
                      <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                      </span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @if ($user->trashed())
                      {{-- Restore Button --}}
                      <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                          Restore
                        </button>
                      </form>
                      {{-- Force Delete Button --}}
                      <form action="{{ route('admin.users.force-delete', $user->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                          Permanent Delete
                        </button>
                      </form>
                    @else
                      {{-- Edit Button --}}
                      <a href="{{ route('admin.users.edit', $user) }}"
                        class="text-indigo-600 hover:text-indigo-900 mr-4">
                        Edit
                      </a>
                      {{-- Delete Button --}}
                      @if ($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-600 hover:text-red-900">
                            Delete
                          </button>
                        </form>
                      @endif
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    No users found. Click "Add New User" to create one.
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
