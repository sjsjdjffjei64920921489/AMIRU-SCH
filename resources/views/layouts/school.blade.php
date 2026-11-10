<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Amiru International School')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark">A</span>
            <span><strong>AMIRU</strong><small>INTERNATIONAL SCHOOL</small></span>
        </a>
        <nav class="main-nav" aria-label="Main navigation">
            <a href="{{ route('home') }}#about">Our school</a>
            <a href="{{ route('home') }}#learning">Academics</a>
            <a href="{{ route('admissions.create') }}">Admissions</a>
        </nav>
        <a class="button button-dark header-login" href="{{ auth()->check() ? route('portal') : route('login') }}">
            {{ auth()->check() ? 'Open portal' : 'Portal login' }}
            <span aria-hidden="true">↗</span>
        </a>
    </header>

    @if (session('status'))
        <div class="flash-message" role="status">{{ session('status') }}</div>
    @endif

    @yield('content')

    <footer class="site-footer">
        <a class="brand brand-light" href="{{ route('home') }}">
            <span class="brand-mark">A</span>
            <span><strong>AMIRU</strong><small>INTERNATIONAL SCHOOL</small></span>
        </a>
        <p>Learning with purpose. Growing together.</p>
        <span>© {{ date('Y') }} Amiru International School</span>
    </footer>
</body>
</html>
