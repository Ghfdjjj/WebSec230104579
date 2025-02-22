@extends('layout')

@section('content')
    <h2>Even Numbers</h2>
    <div class="card">
        <div class="card-header">Even Numbers</div>
        <div class="card-body">
            @foreach (range(1, 100) as $i)
                @if ($i % 2 == 0)
                    <span class="badge bg-primary p-2 m-1">{{ $i }}</span>
                @else
                    <span class="badge bg-secondary p-2 m-1">{{ $i }}</span>
                @endif
            @endforeach
        </div>
    </div>
@endsection
