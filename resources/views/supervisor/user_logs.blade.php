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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Date</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Hours</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Tasks</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Skills</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Challenges</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Learnings</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Status</th>

                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Action</th>
              </tr>

            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($entries as $entry)
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-6 py-5 whitespace-nowrap">
                    <span
                      class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-pink-500 text-white">
                      {{ \Carbon\Carbon::parse($entry->date)->format('M d, Y') }}
                    </span>
                  </td>

                  <td class="px-6 py-5 whitespace-nowrap">
                    <span
                      class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-blue-800">
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
                        <div class="flex justify-center gap-2">
                          <form action="{{ route('supervisor.log.approve', $entry->id) }}" method="POST" class="inline">
                            @csrf @method('POST')
                            <button
                              class="px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 active:bg-green-800 transition-colors duration-200 shadow-sm hover:shadow-md">
                              Approve
                            </button>
                          </form>
        
                            <div x-data="{ showRejectModal: false, remarks: '' }">
                              <!-- Reject Button -->
                              <button @click="showRejectModal = true"
                                class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 active:bg-red-700 transition-colors duration-200 shadow-sm hover:shadow-md">
                                Reject
                              </button>

                              <!-- Reject Modal -->
                              <div x-show="showRejectModal" x-transition.opacity
                                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500/30 p-4"
                                style="display: none;" @click.self="showRejectModal = false"
                                @keydown.escape.window="showRejectModal = false">

                                <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full" @click.stop>
                                  <!-- Icon -->
                                  <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                      viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12">
                                      </path>
                                    </svg>
                                  </div>

                                  <!-- Content -->
                                  <h3 class="mt-4 text-lg font-semibold text-gray-900 text-center">Reject Entry</h3>
                                  <p class="mt-2 text-sm text-gray-600 text-center">
                                    Are you sure you want to reject this log entry?
                                  </p>

                                  <!-- Buttons -->
                                  <div class="mt-6 flex gap-3">
                                    <button @click="showRejectModal = false; remarks = ''"
                                      class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                      Cancel
                                    </button>

                                    <form action="{{ route('supervisor.log.reject', $entry->id) }}" method="POST"
                                      class="flex-1">
                                      @csrf
                                      @method('POST')
                                      <input type="hidden" name="remarks" x-bind:value="remarks">
                                      <button type="submit"
                                        class="w-full px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 transition-colors">
                                        Reject Entry
                                      </button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        @endswitch
                  </td>
                  <td class="px-6 py-5 text-center" x-data="{ showDeleteModal: false }">
                    <button @click="showDeleteModal = true"
                      class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 active:bg-red-700 transition-colors duration-200 shadow-sm hover:shadow-md">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                      </svg>
                      Delete
                    </button>

                    <!-- Delete Modal -->
                    <div x-show="showDeleteModal" x-transition.opacity
                      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
                      style="display: none;" @click.self="showDeleteModal = false"
                      @keydown.escape.window="showDeleteModal = false">

                      <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full" @click.stop>
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                          </svg>
                        </div>

                        <!-- Content -->
                        <h3 class="mt-4 text-lg font-semibold text-gray-900 text-center">Delete Entry</h3>
                        <p class="mt-2 text-sm text-gray-600 text-center">
                          Are you sure you want to delete this entry? This action cannot be undone.
                        </p>

                        <!-- Buttons -->
                        <div class="mt-6 flex gap-3">
                          <button @click="showDeleteModal = false"
                            class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                            Cancel
                          </button>

                          <form action="{{ route('supervisor.log.delete', $entry->id) }}" method="POST"
                            class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                              class="w-full px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 transition-colors">
                              Delete
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td>
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

