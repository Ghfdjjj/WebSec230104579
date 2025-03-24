@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>{{ __('Product Catalog') }}</h1>
        </div>
        <div class="col-auto">
            <form action="{{ route('store.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($products as $product)
            <div class="col">
                <div class="card h-100">
                    @if ($product->image_url)
                        <img src="{{ asset($product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                            <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                                {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                        @auth
                            @if($product->stock_quantity > 0)
                                <div class="mt-2">
                                    @if(auth()->user()->hasSufficientCredit($product->price))
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                        </form>
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            Insufficient credit. Your balance: ${{ number_format(auth()->user()->credit_balance, 2) }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="mt-2">
                                <a href="{{ route('login') }}" class="btn btn-primary">Login to Purchase</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
