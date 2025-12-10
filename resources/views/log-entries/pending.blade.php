@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-clock-history"></i> Pending Log Entries for Review</h2>
        <span class="badge bg-warning text-dark fs-6">{{ $logEntries->total() }} Pending</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($logEntries as $logEntry)
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div>
                    <strong><i class="bi bi-person"></i> {{ $logEntry->user->name }}</strong>
                    <span class="badge bg-warning text-dark ms-2">Pending Review</span>
                </div>
                <div class="text-muted">
                    <i class="bi bi-calendar3"></i> {{ $logEntry->date->format('M d, Y') }} | 
                    <i class="bi bi-clock"></i> {{ $logEntry->hours_worked }} hours
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="text-primary"><i class="bi bi-list-task"></i> Tasks Completed:</h6>
                        <p class="ms-3">{{ $logEntry->tasks }}</p>
                    </div>
                    
                    @if($logEntry->skills)
                    <div class="col-md-6 mb-3">
                        <h6 class="text-success"><i class="bi bi-star"></i> Skills Used:</h6>
                        <p class="ms-3">{{ $logEntry->skills }}</p>
                    </div>
                    @endif
                    
                    @if($logEntry->challenges)
                    <div class="col-md-6 mb-3">
                        <h6 class="text-warning"><i class="bi bi-exclamation-triangle"></i> Challenges:</h6>
                        <p class="ms-3">{{ $logEntry->challenges }}</p>
                    </div>
                    @endif
                    
                    @if($logEntry->learnings)
                    <div class="col-md-6 mb-3">
                        <h6 class="text-info"><i class="bi bi-lightbulb"></i> Learnings:</h6>
                        <p class="ms-3">{{ $logEntry->learnings }}</p>
                    </div>
                    @endif
                </div>
                
                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $logEntry->id }}">
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $logEntry->id }}">
                        <i class="bi bi-x-circle"></i> Reject
                    </button>

                    <a href="{{ route('log-entries.show', $logEntry) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal{{ $logEntry->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('log-entries.approve', $logEntry) }}">
                        @csrf
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="bi bi-check-circle"></i> Approve Log Entry</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to approve this log entry?</p>
                            <div class="alert alert-info">
                                <strong>Intern:</strong> {{ $logEntry->user->name }}<br>
                                <strong>Date:</strong> {{ $logEntry->date->format('F d, Y') }}<br>
                                <strong>Hours:</strong> {{ $logEntry->hours_worked }} hours
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Feedback/Remarks (Optional)</label>
                                <textarea name="remarks" class="form-control" rows="3" placeholder="Add any positive feedback or comments..."></textarea>
                                <small class="text-muted">The intern will be notified with your remarks.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Approve
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal{{ $logEntry->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('log-entries.reject', $logEntry) }}">
                        @csrf
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="bi bi-x-circle"></i> Reject Log Entry</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-danger"><strong>Please provide a detailed reason for rejecting this log entry.</strong></p>
                            <div class="alert alert-warning">
                                <strong>Intern:</strong> {{ $logEntry->user->name }}<br>
                                <strong>Date:</strong> {{ $logEntry->date->format('F d, Y') }}<br>
                                <strong>Hours:</strong> {{ $logEntry->hours_worked }} hours
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                                <textarea name="remarks" class="form-control" rows="4" required placeholder="Explain clearly why this log entry is being rejected so the intern can improve..."></textarea>
                                <small class="text-muted">Be specific and constructive with your feedback.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Reject
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No pending log entries to review at this time.
        </div>
    @endforelse

    <div class="mt-4">
        {{ $logEntries->links() }}
    </div>
</div>
@endsection