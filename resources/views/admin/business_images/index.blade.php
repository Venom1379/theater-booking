@extends('layouts.vertical', ['title' => 'Business Images'])

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Business Images', 'sub_title' => 'Manage images'])

<a href="{{ route('admin.business_images.create') }}" class="btn btn-success mb-3">+ Add Image</a>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Business</th>
                <th>Image</th>
                <th>Alt Text</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $image)
            <tr>
                <td>{{ $image->id }}</td>
                <td>{{ $image->business->name }}</td>
                <td><img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}" width="100"></td>
                <td>{{ $image->alt_text }}</td>
                <td>
                    <form action="{{ route('admin.business_images.destroy', $image->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
