@extends('layouts.school')

@section('title', 'Portal login | Amiru International School')

@section('content')
<main class="form-page">
    <div class="form-intro">
        <p class="eyebrow">AMIRU SCHOOL COMMUNITY</p>
        <h1>Welcome <em>back.</em></h1>
        <p>Sign in to open your student or staff portal.</p>
        <div class="login-aside"><span class="aside-icon">✳</span><p>Your school day, connected.<br><small>Teaching, learning, and school life in one place.</small></p></div>
    </div>
    <form class="school-form" method="POST" action="{{ route('login.store') }}">
        @csrf
        <p class="eyebrow">PORTAL ACCESS</p>
        <h2>Sign in to Amiru</h2>
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
        @error('email')<p class="field-error">{{ $message }}</p>@enderror
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
        @error('password')<p class="field-error">{{ $message }}</p>@enderror
        <label class="checkbox-label"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
        <button class="button button-green button-full" type="submit">Sign in <span aria-hidden="true">↗</span></button>
        <p class="form-help">Need access? Please contact the school office.</p>
    </form>
</main>
@endsection
