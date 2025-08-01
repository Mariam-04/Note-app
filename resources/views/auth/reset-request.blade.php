@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <h2>Forgot Password</h2>

    @if (session('status'))
        <p class="success">{{ session('status') }}</p>
    @endif

    @if ($errors->has('email'))
        <p class="error">{{ $errors->first('email') }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email">Enter your email</label><br>
        <input type="email" name="email" id="email" required><br><br>
        <button type="submit">Send Password Reset Link</button>
    </form>
@endsection
