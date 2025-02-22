@extends('layout')

@section('content')
    <h2>Prime Numbers</h2>
    <div class="card">
        <div class="card-header">Prime Numbers</div>
        <div class="card-body">
            @php
                function isPrime($number) {
                    if ($number < 2) return false;
                    for ($i = 2; $i <= sqrt($number); $i++) {
                        if ($number % $i == 0) return false;
                    }
                    return true;
                }
            @endphp

            @foreach (range(1, 100) as $i)
                @if (isPrime($i))
                    <span class="badge bg-primary p-2 m-1">{{ $i }}</span>
                @else
                    <span class="badge bg-secondary p-2 m-1">{{ $i }}</span>
                @endif
            @endforeach
        </div>
    </div>
@endsection
