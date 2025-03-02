@extends('layout')

@section('content')
<div class="container">
    <h1>Grades</h1>
    <a href="{{ route('grades.create') }}" class="btn btn-primary mb-3">Create New Grade</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Grade</th>
                <th>Credit Hours</th>
                <th>Term</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr>
                    <td>{{ $grade->course_name }}</td>
                    <td>{{ $grade->grade }}</td>
                    <td>{{ $grade->credit_hours }}</td>
                    <td>{{ $grade->term }}</td>
                    <td>
                        <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this grade?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection