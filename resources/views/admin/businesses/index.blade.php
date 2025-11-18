@extends('layouts.vertical', ['title' => 'Businesses'])

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Businesses', 'sub_title' => 'Manage Listings'])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.businesses.create') }}" class="btn btn-primary mb-3">+ Add Business</a>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($businesses as $business)
                                <tr>
                                    <td>{{ $business->id }}</td>
                                    <td>{{ $business->name }}</td>
                                    <td>{{ $business->category->name }}</td>
                                    <td>{{ $business->city->name }}</td>
                                    <td>
                                        @if($business->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($business->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.businesses.show', $business->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.businesses.edit', $business->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.businesses.destroy', $business->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        @if($business->status == 'pending')
                                            <form action="{{ route('admin.businesses.approve', $business->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            </div> 
        </div>
    </div>
</div>

@endsection
