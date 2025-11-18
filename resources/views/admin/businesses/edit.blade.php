@extends('layouts.vertical', ['title' => 'Edit Business'])

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Edit Business'])

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.businesses.update', $business->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $business->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $business->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <select name="city_id" class="form-control" required>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $business->city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $business->address }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $business->phone }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $business->email }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="url" name="website" class="form-control" value="{{ $business->website }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Business</button>
        </form>
    </div>
</div>
@endsection
