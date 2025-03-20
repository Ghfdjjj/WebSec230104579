@extends('layouts.master')

@section('title', 'Products List')

@section('content')
<div class="container mt-4">
    <h1>Products</h1>

    <!-- Button to Create Product -->
    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
    </div>
    @endif

    <!-- Search/Filter Form -->
    <form method="GET" action="{{ route('products_list') }}" class="mb-4">
        <div class="row">
            <div class="col-sm-3">
                <input type="text" name="keywords" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}">
            </div>
            <div class="col-sm-2">
                <input type="number" step="0.01" name="min_price" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}">
            </div>
            <div class="col-sm-2">
                <input type="number" step="0.01" name="max_price" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}">
            </div>
            <div class="col-sm-2">
                <select name="order_by" class="form-select">
                    <option value="" disabled {{ request()->order_by ? '' : 'selected' }}>Order By</option>
                    <option value="name" {{ request()->order_by=='name' ? 'selected' : '' }}>Name</option>
                    <option value="price" {{ request()->order_by=='price' ? 'selected' : '' }}>Price</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select name="order_direction" class="form-select">
                    <option value="ASC" {{ request()->order_direction=='ASC' ? 'selected' : '' }}>ASC</option>
                    <option value="DESC" {{ request()->order_direction=='DESC' ? 'selected' : '' }}>DESC</option>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-primary">Go</button>
            </div>
        </div>
    </form>

    <!-- Products List -->
    @foreach($products as $product)
    <div class="card mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="img-thumbnail" width="200">
                </div>
                <div class="col-md-8">
                    <h3>{{ $product->name }}</h3>
                    <p>{{ $product->description }}</p>
                    <p><strong>Price:</strong> ${{ $product->price }}</p>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('products_edit', $product->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
