@extends('layout')

@section('content')
<div class="container">
    <h1>Student transcript</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Transcript as $entry)
                <tr>
                    <td>{{ $entry['course'] }}</td>
                    <td>{{ $entry['grade'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection