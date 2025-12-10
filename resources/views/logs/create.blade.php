@extends('layouts.app')

@section('title', 'Add Log Entry - Internship Log Book')

@section('content')

<div class="min-h-screen bg-gray-50 py-12">

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b">

                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    📝 Add Log Entry
                </h3>

            </div>

            {{-- BODY --}}
            <div class="p-6">

                {{-- SUCCESS --}}
                @if(session('success'))
                    <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ERRORS --}}
                @if($errors->any())
                    <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                        <ul class="list-disc ml-5 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form method="POST" action="{{ route('logs.store') }}">
                    @csrf


                    {{-- TOP INPUTS --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- DATE --}}
                        <div>
                            <label class="block text-gray-600 mb-1">Date</label>

                            <input type="date"
                                   name="date"
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        {{-- HOURS --}}
                        <div>
                            <label class="block text-gray-600 mb-1">Hours Worked</label>

                            <input type="number"
                                   name="hours_worked"
                                   min="0"
                                   max="24"
                                   step="0.5"
                                   value="{{ old('hours_worked') }}"
                                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                    </div>


                    {{-- TASKS --}}
                    <div class="mt-6">
                        <label class="block text-gray-600 mb-1">Tasks / Activities</label>

                        <textarea name="tasks"
                                  rows="4"
                                  class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                  placeholder="Describe what you worked on today...">{{ old('tasks') }}</textarea>
                    </div>


                    {{-- SKILLS + CHALLENGES --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                        <div>
                            <label class="block text-gray-600 mb-1">Skills Applied</label>
                            <input type="text"
                                   name="skills"
                                   value="{{ old('skills') }}"
                                   class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                   placeholder="e.g., PHP, Laravel, Tailwind">
                        </div>

                        <div>
                            <label class="block text-gray-600 mb-1">Challenges Faced</label>
                            <textarea name="challenges"
                                      rows="2"
                                      class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                      placeholder="Any difficulties?">{{ old('challenges') }}</textarea>
                        </div>

                    </div>


                    {{-- LEARNINGS --}}
                    <div class="mt-6">
                        <label class="block text-gray-600 mb-1">Learning Outcomes</label>

                        <textarea name="learnings"
                                  rows="2"
                                  class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                  placeholder="What did you learn today?">{{ old('learnings') }}</textarea>
                    </div>


                    {{-- BUTTONS --}}
                    <div class="flex justify-end gap-3 mt-10 border-t pt-6">

                        <a href="{{ route('dashboard') }}"
                           class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                           Cancel
                        </a>

                        <button type="submit"
                                class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition shadow">
                            Save Entry
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection
