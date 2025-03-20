@extends('layouts.master')

@section('title', 'Create Student')

@section('content')
<div class="container mt-4">
    <h1>Create Student</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age:</label>
            <input type="number" id="age" name="age" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="major" class="form-label">Major:</label>
            <input type="text" id="major" name="major" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Student</button>
    </form>
</div>
@endsection
