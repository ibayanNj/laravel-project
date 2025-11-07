<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Internship Log Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>
<body>
    <!-- NAVBAR -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="#">
            <span class="bg-white bg-opacity-10 rounded-3 p-2 me-2">📋</span>
            <span class="d-none d-md-inline">Internship Log Book</span>
            <span class="d-inline d-md-none">Log Book</span>
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <div class="d-flex align-items-center bg-white bg-opacity-10 rounded-pill px-3 py-2">
                <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                    <span class="fw-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <span class="text-white fw-medium d-none d-sm-inline">{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light rounded-pill px-4 py-2 fw-medium shadow-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    <span class="d-none d-sm-inline">Logout</span>
                    <span class="d-inline d-sm-none">
                        <i class="bi bi-box-arrow-right"></i>
                    </span>
                </button>
            </form>
        </div>
    </div>
</nav> -->

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="#">
            <span class="bg-white bg-opacity-10 rounded-3 p-2 me-2">📋</span>
            <span class="d-none d-md-inline">Internship Log Book</span>
            <span class="d-inline d-md-none">Log Book</span>
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- User Profile Display -->
            <div class="d-flex align-items-center bg-white bg-opacity-10 rounded-pill px-3 py-2">
                <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                    <span class="fw-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <span class="text-white fw-medium d-none d-sm-inline">{{ Auth::user()->name }}</span>
            </div>

            <!-- Example: Only show this section if user is NOT supervisor -->
            @if(Auth::user()->role === 'user')
                <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 py-2 fw-medium shadow-sm">
                    <i class="bi bi-journal-text me-1"></i> My Logs
                </a>
            @endif

            <!-- Example: Only show this section if supervisor -->
            @if(Auth::user()->role === 'supervisor')
                <a href="{{ route('supervisor.index') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-medium shadow-sm">
                    <i class="bi bi-person-lines-fill me-1"></i> Supervisor Panel
                </a>
            @endif

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light rounded-pill px-4 py-2 fw-medium shadow-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    <span class="d-none d-sm-inline">Logout</span>
                    <span class="d-inline d-sm-none">
                        <i class="bi bi-box-arrow-right"></i>
                    </span>
                </button>
            </form>
        </div>
    </div>
</nav>


                <!-- ADD LOG ENTRY FORM -->

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
  <div class="row justify-content-center">
    <div class="col-12 col-md-11 col-lg-10">
      <div class="card border-0 shadow-lg rounded-4 w-100">
        <div class="card-header bg-dark text-white rounded-top-4">
          <h5 class="mb-0 fw-semibold">
            <i class="bi bi-journal-text me-2"></i> Add Log Entry
          </h5>
        </div>

<div class="card-body p-4 p-md-5">
  <form method="POST" action="{{ route('log.store') }}">
    @csrf

    <div class="row g-4">
      <div class="col-sm-6 col-lg-3">
        <label class="form-label fw-semibold text-secondary mb-2">
          <span class="text-primary">📅</span> Date
        </label>
        <input type="date" name="date" class="form-control form-control-lg border-2 rounded-4 shadow-sm" required>
      </div>

      <div class="col-sm-6 col-lg-3">
        <label class="form-label fw-semibold text-secondary mb-2">
          <span class="text-primary">⏰</span> Hours Worked
        </label>
        <input type="number" name="hours_worked" class="form-control form-control-lg border-2 rounded-4 shadow-sm" placeholder="8" required>
      </div>

      <div class="col-12">
        <label class="form-label fw-semibold text-secondary mb-2">
          <span class="text-primary">📝</span> Tasks / Activities
        </label>
        <textarea name="tasks" class="form-control form-control-lg border-2 rounded-4 shadow-sm" rows="4" placeholder="Describe what you worked on today..." required></textarea>
      </div>

      <div class="col-sm-6 col-lg-6">
        <label class="form-label fw-semibold text-secondary mb-2">
          <span class="text-primary">💡</span> Skills Applied
        </label>
        <input type="text" name="skills" class="form-control form-control-lg border-2 rounded-4 shadow-sm" placeholder="e.g., PHP, Laravel, Bootstrap">
      </div>

      <div class="col-sm-6 col-lg-6">
        <label class="form-label fw-semibold text-secondary mb-2">
          <span class="text-warning">⚠️</span> Challenges Faced
        </label>
        <textarea name="challenges" class="form-control form-control-lg border-2 rounded-4 shadow-sm" rows="2" placeholder="Any difficulties or obstacles?"></textarea>
      </div>

      <div class="col-12">
        <label class="form-label fw-semibold text-secondary mb-2">
          <span class="text-success">🎯</span> Learning Outcomes
        </label>
        <textarea name="learnings" class="form-control form-control-lg border-2 rounded-4 shadow-sm" rows="2" placeholder="What did you learn today?"></textarea>
      </div>
    </div>

    <div class="d-flex justify-content-end gap-3 mt-5 pt-3 border-top">
      <button type="reset" class="btn btn-lg btn-outline-secondary rounded-pill px-5 py-2 shadow-sm">
        Cancel
      </button>
      <button type="submit" class="btn btn-lg btn-dark rounded-pill px-5 py-2 shadow">
        <i class="bi bi-save me-2"></i> Save Entry
      </button>
    </div>
  </form>
</div>
      </div>
    </div>
  </div>



<!-- RECENT LOGS -->
<!-- <h5 class="mb-3">Recent Log Entries</h5>
<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Date</th>
                <th>Hours Worked</th>
                <th>Tasks / Activities</th>
                <th>Skills Applied</th>
                <th>Challenges Faced</th>
                <th>Learning Outcomes</th>
            </tr>
        </thead>
        <tbody>
            @if($logs->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No entries yet. Start logging your internship activities by clicking 
                        <strong>"Add New Log Entry"</strong> above.
                    </td>
                </tr>
            @else
                @foreach($logs as $log)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($log->date)->format('F d, Y') }}</td>
                        <td class="text-center">{{ $log->hours_worked }} hrs</td>
                        <td>{{ $log->tasks }}</td>
                        <td>{{ $log->skills ?? '—' }}</td>
                        <td>{{ $log->challenges ?? '—' }}</td>
                        <td>{{ $log->learnings ?? '—' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div> -->

<!-- <div class="container-fluid py-5" style="background-color: #f8f9fa;">
  <div class="row justify-content-center">
    <div class="col-12 col-md-11 col-lg-10">
      <div class="card border-0 shadow-lg rounded-4 w-100">
        <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between align-items-center">
          <h5 class="mb-0 fw-semibold">
            <i class="bi bi-clock-history me-2"></i> Recent Log Entries
          </h5>
        </div>

        <div class="card-body p-4 p-md-5">
          <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle mb-0">
              <thead class="table-dark text-center">
                <tr>
                  <th>Date</th>
                  <th>Hours Worked</th>
                  <th>Tasks / Activities</th>
                  <th>Skills Applied</th>
                  <th>Challenges Faced</th>
                  <th>Learning Outcomes</th>
                </tr>
              </thead>
              <tbody>
                @if($logs->isEmpty())
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                      No entries yet. Start logging your internship activities by clicking 
                      <strong>"Add New Log Entry"</strong> above.
                    </td>
                  </tr>
                @else
                  @foreach($logs as $log)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($log->date)->format('F d, Y') }}</td>
                      <td class="text-center">{{ $log->hours_worked }} hrs</td>
                      <td>{{ $log->tasks }}</td>
                      <td>{{ $log->skills ?? '—' }}</td>
                      <td>{{ $log->challenges ?? '—' }}</td>
                      <td>{{ $log->learnings ?? '—' }}</td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<br>
  <div class="row justify-content-center">
    <div class="col-12 col-md-11 col-lg-10">
      <div class="card border-0 shadow-2xl rounded-4 overflow-hidden" style="backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.98);">
        

        <div class="card-header border-0 py-4 px-4 px-md-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <div class="rounded-circle p-3 me-3" style="background: rgba(255, 255, 255, 0.2);">
                <i class="bi bi-clock-history fs-4 text-white"></i>
              </div>
              <div>
                <h4 class="mb-0 text-white fw-bold">Recent Log Entries</h4>
                <p class="mb-0 text-white-50 small mt-1">Track your internship journey</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body p-4 p-md-5">
          @if($logs->isEmpty())

            <div class="text-center py-5">
              <div class="mb-4">
                <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                     style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);">
                  <i class="bi bi-journal-text" style="font-size: 3rem; color: #667eea;"></i>
                </div>
              </div>
              <h5 class="fw-bold mb-2" style="color: #2d3748;">No Entries Yet</h5>
              <p class="text-muted mb-4">Start documenting your internship experience</p>
              <button class="btn btn-lg px-4 py-2 rounded-pill" 
                      style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; font-weight: 500;">
                <i class="bi bi-plus-circle me-2"></i>Add Your First Entry
              </button>
            </div>
          @else

            <div class="row g-4">
              @foreach($logs as $log)
                <div class="col-12">
                  <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 hover-lift" 
                       style="transition: all 0.3s ease; border-left: 4px solid #667eea !important;">
                    <div class="card-body p-4">
                      <div class="row align-items-start">
                        <div class="col-12 col-lg-2 mb-3 mb-lg-0">
                          <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);">
                            <div class="fw-bold" style="color: #667eea; font-size: 1.5rem;">
                              {{ \Carbon\Carbon::parse($log->date)->format('d') }}
                            </div>
                            <div class="text-muted small">{{ \Carbon\Carbon::parse($log->date)->format('M Y') }}</div>
                            <div class="mt-2 pt-2" style="border-top: 1px solid #e2e8f0;">
                              <i class="bi bi-clock me-1" style="color: #667eea;"></i>
                              <span class="fw-semibold" style="color: #2d3748;">{{ $log->hours_worked }}h</span>
                            </div>
                          </div>
                        </div>


                        <div class="col-12 col-lg-10">
                          <div class="row g-3">

                            <div class="col-12">
                              <div class="d-flex align-items-start">
                                <div class="rounded-circle p-2 me-3" style="background: #667eea15;">
                                  <i class="bi bi-check-circle-fill" style="color: #667eea;"></i>
                                </div>
                                <div class="flex-grow-1">
                                  <h6 class="fw-bold mb-1" style="color: #2d3748;">Tasks & Activities</h6>
                                  <p class="mb-0 text-muted">{{ $log->tasks }}</p>
                                </div>
                              </div>
                            </div>


                            <div class="col-12">
                              <div class="row g-3">
                                @if($log->skills)
                                  <div class="col-12 col-md-4">
                                    <div class="p-3 rounded-3 h-100" style="background: #f7fafc; border-left: 3px solid #48bb78;">
                                      <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-lightning-charge-fill me-2" style="color: #48bb78;"></i>
                                        <small class="fw-semibold text-uppercase" style="color: #48bb78; letter-spacing: 0.5px;">Skills</small>
                                      </div>
                                      <p class="mb-0 small" style="color: #4a5568;">{{ $log->skills }}</p>
                                    </div>
                                  </div>
                                @endif

                                @if($log->challenges)
                                  <div class="col-12 col-md-4">
                                    <div class="p-3 rounded-3 h-100" style="background: #fffaf0; border-left: 3px solid #ed8936;">
                                      <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-exclamation-triangle-fill me-2" style="color: #ed8936;"></i>
                                        <small class="fw-semibold text-uppercase" style="color: #ed8936; letter-spacing: 0.5px;">Challenges</small>
                                      </div>
                                      <p class="mb-0 small" style="color: #4a5568;">{{ $log->challenges }}</p>
                                    </div>
                                  </div>
                                @endif

                                @if($log->learnings)
                                  <div class="col-12 col-md-4">
                                    <div class="p-3 rounded-3 h-100" style="background: #f0f4ff; border-left: 3px solid #667eea;">
                                      <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-lightbulb-fill me-2" style="color: #667eea;"></i>
                                        <small class="fw-semibold text-uppercase" style="color: #667eea; letter-spacing: 0.5px;">Learnings</small>
                                      </div>
                                      <p class="mb-0 small" style="color: #4a5568;">{{ $log->learnings }}</p>
                                    </div>
                                  </div>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- <div class="container-fluid py-5 bg-dark min-vh-100">
  <div class="row justify-content-center">
    <div class="col-12 col-md-11 col-lg-10">
      <div class="card bg-dark text-white border-0 shadow-lg rounded-4 overflow-hidden">
        
        <div class="card-header border-0 py-4 px-4 px-md-5 bg-secondary">
          <div class="d-flex align-items-center">
            <i class="bi bi-clock-history fs-4 me-3"></i>
            <div>
              <h4 class="mb-0 fw-bold">Recent Log Entries</h4>
              <p class="mb-0 small">Track your internship journey</p>
            </div>
          </div>
        </div>

        <div class="card-body p-4 p-md-5">
          @if($logs->isEmpty())
            <div class="text-center py-5">
              <i class="bi bi-journal-text display-4 mb-3"></i>
              <h5 class="fw-bold mb-2">No Entries Yet</h5>
              <p class="mb-4">Start documenting your internship experience</p>
              <button class="btn btn-light text-dark fw-semibold">
                <i class="bi bi-plus-circle me-2"></i>Add Your First Entry
              </button>
            </div>
          @else
            <div class="table-responsive">
              <table class="table table-dark table-hover align-middle mb-0 text-white">
                <thead class="text-white">
                  <tr>
                    <th style="white-space: nowrap; width: 150px;">Date</th>
                    <th>Hours</th>
                    <th>Tasks & Activities</th>
                    <th>Skills</th>
                    <th>Challenges</th>
                    <th>Learnings</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($logs as $log)
                    <tr>
                      <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($log->date)->format('M d, Y') }}</td>
                      <td>{{ $log->hours_worked }}h</td>
                      <td>{{ $log->tasks }}</td>
                      <td>{{ $log->skills ?? '—' }}</td>
                      <td>{{ $log->challenges ?? '—' }}</td>
                      <td>{{ $log->learnings ?? '—' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div> -->




<style>
.hover-lift {
  transition: all 0.3s ease;
}

.hover-lift:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15) !important;
}

.shadow-2xl {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}


.form-control:focus {
  outline: none;
}

textarea.form-control {
  resize: vertical;
  min-height: 80px;
}

</style>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
