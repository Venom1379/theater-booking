@extends('layouts.vertical', ['title' => 'Business Tags'])

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Business Tags', 'sub_title' => 'Manage tags'])

<a href="{{ route('admin.business_tags.create') }}" class="btn btn-success mb-3">+ Add Tag</a>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Business</th>
                <th>Tag</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->id }}</td>
                <td>{{ $tag->business->name }}</td>
                <td>{{ $tag->tag }}</td>
                <td>
                    <form action="{{ route('admin.business_tags.destroy', $tag->id) }}" method="POST">
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
