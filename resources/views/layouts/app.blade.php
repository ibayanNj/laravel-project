<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/profile.png') }}" type="image/png">
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <title>@yield('title', 'Internship Log Book')</title>
    @vite('resources/css/app.css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>

    @unless (request()->routeIs('login') || request()->routeIs('register'))
        <x-navbar />
    @endunless
    

    @yield('content')


    @unless (request()->routeIs('login') || request()->routeIs('register'))
        <x-footer />
    @endunless

    @stack('scripts')
</body>
</html>

