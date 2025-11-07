@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/supervisor-dashboard.css') }}">

<div class="dashboard-container">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="header-top">
                <div class="title-section">
                    <div class="icon-wrapper">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="dashboard-title">Supervisor Dashboard</h1>
                        <div class="title-accent"></div>
                    </div>
                </div>
                <div class="header-actions">
                    <div class="stats-badge">
                        <span class="stats-number">{{ count($users) }}</span>
                        <span class="stats-label">Users</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            <p class="dashboard-subtitle">Select a user to view their log entries and track progress</p>
        </div>

        <div class="users-grid">
            @foreach($users as $user)
                <a href="{{ route('supervisor.user.logs', $user->id) }}" class="user-card">
                    <div class="user-card-inner">
                        <div class="user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            <div class="avatar-ring"></div>
                        </div>
                        <div class="user-info">
                            <h3 class="user-name">{{ $user->name }}</h3>
                            <p class="user-role">Team Member</p>
                        </div>
                        <div class="card-arrow">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
