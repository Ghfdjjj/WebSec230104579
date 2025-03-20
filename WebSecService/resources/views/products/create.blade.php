@extends('layouts.master')

@section('title', 'Add Product')

@section('content')
    <div class="container">
        <h2>Add New Product</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Product Image</label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Save Product</button>
        </form>
    </div>
@endsection
