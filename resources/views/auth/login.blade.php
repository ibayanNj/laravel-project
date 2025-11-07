




@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <h2>Welcome Back</h2>

    @if ($errors->any())
        <div class="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email address</label>
            <input type="email"
                   class="form-control"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password"
                   class="form-control"
                   id="password"
                   name="password"
                   required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>
            <a href="#" class="small text-primary text-decoration-none">Forgot Password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Continue
        </button>

        <div class="auth-footer">
            New here? <a href="{{ route('register') }}">Create an account</a>
        </div>
    </form>
</div>
@endsection
