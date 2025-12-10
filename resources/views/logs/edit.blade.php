{{-- resources/views/logs/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Log Entry - Internship Log Book')

@section('content')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-800 text-sm">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Page Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Log Entry</h1>
                <p class="text-gray-600 text-sm mt-1">
                    {{ \Carbon\Carbon::parse($log->date)->format('l, F j, Y') }} 
                    • {{ $log->hours_worked }} hours
                </p>
            </div>
            <a href="{{ route('logs.index') }}"
               class="px-4 py-2 rounded-lg bg-white border hover:bg-gray-50 text-gray-700 text-sm font-medium transition">
                ← Back to All Logs
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-lg border shadow-sm">
            <div class="p-6">
                <form action="{{ route('logs.update', $log->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   id="date"
                                   name="date"
                                   value="{{ old('date', $log->date) }}"
                                   required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        <!-- Hours Worked -->
                        <div>
                            <label for="hours_worked" class="block text-sm font-medium text-gray-700 mb-2">
                                Hours Worked <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   id="hours_worked"
                                   name="hours_worked"
                                   value="{{ old('hours_worked', $log->hours_worked) }}"
                                   min="0.5"
                                   step="0.5"
                                   required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="mt-6">
                        <label for="tasks" class="block text-sm font-medium text-gray-700 mb-2">
                            Tasks Performed
                        </label>
                        <textarea id="tasks"
                                  name="tasks"
                                  rows="4"
                                  placeholder="What did you work on today?"
                                  class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none">{{ old('tasks', $log->tasks) }}</textarea>
                    </div>

                    <!-- Skills -->
                    <div class="mt-6">
                        <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">
                            Skills Gained / Used
                        </label>
                        <input type="text"
                               id="skills"
                               name="skills"
                               value="{{ old('skills', $log->skills) }}"
                               placeholder="e.g. Laravel, Tailwind, API Design"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <!-- Challenges -->
                    <div class="mt-6">
                        <label for="challenges" class="block text-sm font-medium text-gray-700 mb-2">
                            Challenges Faced
                        </label>
                        <input type="text"
                               id="challenges"
                               name="challenges"
                               value="{{ old('challenges', $log->challenges) }}"
                               placeholder="e.g. Debugging CORS issue"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <!-- Learnings -->
                    <div class="mt-6">
                        <label for="learnings" class="block text-sm font-medium text-gray-700 mb-2">
                            Key Learnings
                        </label>
                        <input type="text"
                               id="learnings"
                               name="learnings"
                               value="{{ old('learnings', $log->learnings) }}"
                               placeholder="e.g. Better understanding of middleware"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex gap-3 justify-end">
                        <a href="{{ route('logs.index') }}"
                           class="px-5 py-2.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                            Update Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection