@extends('layouts.vertical', ['title' => 'Add Business'])

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Add Business'])

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.businesses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <select name="city_id" class="form-control" required>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="url" name="website" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Add Business</button>
        </form>
    </div>
</div>
@endsection
