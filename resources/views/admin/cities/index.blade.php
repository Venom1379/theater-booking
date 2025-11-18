@extends('layouts.vertical', ['title' => 'Cities', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
@endsection

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Cities', 'sub_title' => ''])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Cities</h4>
                    <!-- Add City Button -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCityModal">
                        <i class="fas fa-plus"></i> Add City
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">State</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $city)
                                <tr>
                                    <td>{{ $city->id }}</td>
                                    <td>{{ $city->name }}</td>
                                    <td>{{ $city->state->name ?? 'N/A' }}</td> <!-- Show state name -->
                                    <td>{{ $city->slug }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCityModal{{ $city->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this city?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit City Modal -->
                                <div class="modal fade" id="editCityModal{{ $city->id }}" tabindex="-1" aria-labelledby="editCityLabel{{ $city->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCityLabel{{ $city->id }}">Edit City</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name{{ $city->id }}" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name{{ $city->id }}" name="name" value="{{ $city->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="state_id{{ $city->id }}" class="form-label">State</label>
                                                        <select class="form-control" id="state_id{{ $city->id }}" name="state_id" required>
                                                            <option value="">Select State</option>
                                                            @foreach($states as $state)
                                                                <option value="{{ $state->id }}" {{ $state->id == $city->state_id ? 'selected' : '' }}>{{ $state->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive -->
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<!-- Add City Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCityLabel">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.cities.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="state_id" class="form-label">State</label>
                        <select class="form-control" id="state_id" name="state_id" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add City</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
