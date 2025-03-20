@extends('layouts.master')

@section('title', 'Edit Student')

@section('content')
<div class="container">
    <h2>Edit Student</h2>
    <form action="{{ route('students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="{{ $student->age }}" required>
        </div>
        <div class="mb-3">
            <label for="major" class="form-label">Major</label>
            <input type="text" name="major" class="form-control" value="{{ $student->major }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Student</button>
    </form>
</div>
@endsection
