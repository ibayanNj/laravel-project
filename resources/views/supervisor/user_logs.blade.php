@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/log-entries.css') }}">

<div class="log-container">
    <div class="log-card">
        <div class="card-header-custom">
            <div class="header-content">
                <div class="title-wrapper">
                    <div class="accent-line"></div>
                    <h2 class="page-title">Log Entries</h2>
                </div>
                <p class="user-name">{{ $user->name }}</p>
            </div>
            <a href="{{ route('supervisor.index') }}" class="btn-back">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
        </div>

        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Hours</th>
                        <th>Tasks</th>
                        <th>Skills</th>
                        <th>Challenges</th>
                        <th>Learnings</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entries as $entry)
                        <tr>
                            <td data-label="Date" class="text-nowrap">
                                <span class="date-badge">{{ $entry->date }}</span>
                            </td>
                            <td data-label="Hours">
                                <span class="hours-badge">{{ $entry->hours_worked }}h</span>
                            </td>
                            <td data-label="Tasks">
                                <div class="text-content">{{ $entry->tasks }}</div>
                            </td>
                            <td data-label="Skills">
                                <div class="text-content">{{ $entry->skills }}</div>
                            </td>
                            <td data-label="Challenges">
                                <div class="text-content">{{ $entry->challenges }}</div>
                            </td>
                            <td data-label="Learnings">
                                <div class="text-content">{{ $entry->learnings }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
