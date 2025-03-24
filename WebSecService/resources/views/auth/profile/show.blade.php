@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <p class="form-control-static">{{ ucfirst($user->role) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Credit Balance</label>
                        <p class="form-control-static">${{ number_format($user->credit_balance, 2) }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                        <a href="{{ route('purchase.history') }}" class="btn btn-secondary">Purchase History</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
