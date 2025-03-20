@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<div class="container">
    <h2>Profile</h2>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <a href="{{ route('password.request') }}" class="btn btn-primary">Change Password</a>

    <!-- Logout Form (Hidden) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Logout Button -->
    <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
</div>
@endsection
