@extends('layouts.vertical', ['title' => 'Countries'])
@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Countries', 'sub_title' => 'Tables'])

<div class="container">
    
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStateModal">Add State</button>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($states as $state)
            <tr>
                <td>{{ $state->id }}</td>
                <td>{{ $state->name }}</td>
                <td>{{ $state->country->name }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStateModal{{ $state->id }}">Edit</button>
                    <form action="{{ route('admin.states.destroy', $state->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit State Modal -->
            <div class="modal fade" id="editStateModal{{ $state->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('admin.states.update', $state->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit State</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label for="name">State Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $state->name }}" required>

                                <label for="country_id">Country</label>
                                <select name="country_id" class="form-control" required>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if($state->country_id == $country->id) selected @endif>
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add State Modal -->
<div class="modal fade" id="addStateModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.states.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="name">State Name</label>
                    <input type="text" name="name" class="form-control" required>

                    <label for="country_id">Country</label>
                    <select name="country_id" class="form-control" required>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
