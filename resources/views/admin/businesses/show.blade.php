@extends('layouts.vertical', ['title' => 'Business Details'])

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Business Details'])

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">{{ $business->name }}</h3>
                
                <div class="mb-3">
                    <span class="badge bg-primary">{{ $business->category->name }}</span>
                    <span class="badge bg-info">{{ $business->subCategory->name }}</span>
                </div>

                <p><strong>Address:</strong> {{ $business->address }}</p>
                <p><strong>City:</strong> {{ $business->city->name }}</p>
                <p><strong>State:</strong> {{ $business->state->name }}</p>
                <p><strong>Country:</strong> {{ $business->country->name }}</p>

                <hr>

                <p><strong>Phone:</strong> <a href="tel:{{ $business->phone }}">{{ $business->phone }}</a></p>
                <p><strong>Phone 2:</strong> <a href="tel:{{ $business->phone_2 }}">{{ $business->phone_2 }}</a></p>
                <p><strong>Email:</strong> <a href="mailto:{{ $business->email }}">{{ $business->email }}</a></p>
                <p><strong>Website:</strong> <a href="{{ $business->website }}" target="_blank">{{ $business->website }}</a></p>

                <hr>

                <p><strong>Status:</strong> 
                    @if($business->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($business->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </p>

                <p><strong>Rating:</strong> ⭐ {{ $business->rating }} / 5</p>

                <div class="mt-4">
                    <a href="{{ route('admin.businesses.index') }}" class="btn btn-secondary">Back</a>
                    @if($business->status == 'pending')
                        <a href="{{ route('admin.businesses.approve', $business->id) }}" class="btn btn-success">Approve</a>
                    @endif
                    @if($business->status == 'approved')
                        <a href="{{ route('admin.businesses.disapprove', $business->id) }}" class="btn btn-warning">Disapprove</a>
                    @endif
                    <a href="{{ route('admin.businesses.edit', $business->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('admin.businesses.destroy', $business->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Business Logo</h5>
                @if($business->logo)
                    <img src="{{ asset('storage/' . $business->logo) }}" class="img-fluid rounded mb-3" alt="Business Logo">
                @else
                    <img src="{{ asset('images/default-logo.png') }}" class="img-fluid rounded mb-3" alt="Default Logo">
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
