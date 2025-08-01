@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h2>Login Form</h2>

    @if($errors->has('login'))
        <p class="error">{{ $errors->first('login') }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

        <div class="reset-link">
            <a href="/forgot-password" class="reset-btn">Reset Password</a>
        </div>
    </form>
@endsection
