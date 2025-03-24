@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Profile Information</h3>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Credit Balance:</strong> ${{ number_format($user->credit_balance, 2) }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Actions</h3>
                    <a href="{{ route('password.request') }}" class="btn btn-primary mb-2">Change Password</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Purchase History</h3>
                    @if($user->purchases->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                                            <td>{{ $purchase->product->name }}</td>
                                            <td>{{ $purchase->quantity }}</td>
                                            <td>${{ number_format($purchase->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $purchase->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($purchase->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No purchase history found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
