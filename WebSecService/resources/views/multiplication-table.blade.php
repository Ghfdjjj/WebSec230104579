@extends('layout')

@section('content')
    <h2>Multiplication Table (1-10)</h2>

    @for ($i = 1; $i <= 10; $i++)
        <h3>Table of {{ $i }}</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Multiplication</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @for ($j = 1; $j <= 10; $j++)
                    <tr>
                        <td>{{ $i }} x {{ $j }}</td>
                        <td>{{ $i * $j }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    @endfor
@endsection
