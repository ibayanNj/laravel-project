<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK-eLog - Streamline Your Task Management</title>
    <link rel="icon" href="{{ asset('images/profile.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing-page.css') }}">
    <script src="{{ asset('js/nav.js') }}"></script>

    <style>

    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg glass-nav fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-check2-square"></i> TASK-eLog
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Get Started</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>

                <li class="nav-item ms-lg-2">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">Manage Tasks with TASK-eLog</h1>
                    <p class="lead mb-4">A Web-based internship logbook system designed to help interns conveniently
                        record and manage their daily or weekly internship activities online. </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg cta-button text-white">
                            Start
                        </a>

                        <a href="#features" class="btn btn-outline-light btn-lg">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <i class="bi bi-clipboard-check" style="font-size: 300px; opacity: 0.9;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Features</h2>
                <p class="lead text-muted">Everything you need to manage tasks efficiently</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="feature-icon mx-auto">
                            <i class="bi bi-list-task"></i>
                        </div>
                        <h4 class="text-center mb-3">Daily Logging</h4>
                        <p class="text-muted text-center">Create, organize, and prioritize tasks with ease. Set
                            deadlines and track progress in real-time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="feature-icon mx-auto">
                            <i class="bi bi-bell"></i>
                        </div>
                        <h4 class="text-center mb-3">Approval</h4>
                        <p class="text-muted text-center">Stay updated</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="feature-icon mx-auto">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4 class="text-center mb-3">Weekly Reports</h4>
                        <p class="text-muted text-center">Get insights into productivity trends and generate
                            comprehensive reports for better decision-making.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <i class="bi bi-journal-check text-primary" style="font-size: 250px; opacity: 0.8;"></i>
                </div>
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4">About TASK-eLog</h2>
                    <p class="lead mb-4">TASK-eLog is a comprehensive task management solution designed to help
                        individuals and teams stay organized and productive.</p>
                    <p class="text-muted mb-4">Whether you're managing personal projects or coordinating with a large
                        team, TASK-eLog provides the tools you need to track tasks, monitor progress, and achieve your
                        goals efficiently.</p>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-check2-square"></i> TASK-eLog</h5>
                    <p class="text-muted">Streamline your workflow and boost productivity.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 TASK-eLog. All rights reserved.</p>
                    <div class="mt-2">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
