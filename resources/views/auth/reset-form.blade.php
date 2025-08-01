@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <h2>Reset Password</h2>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>New Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Reset Password</button>
    </form>
@endsection
