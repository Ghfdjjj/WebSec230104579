@extends('layout')

@section('content')
<div class="container">
    <h1>Supermarket Bill</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bill->items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total: ${{ number_format($bill->total, 2) }}</h3>
</div>
@endsection