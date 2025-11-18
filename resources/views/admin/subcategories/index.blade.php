@extends('layouts.vertical', ['title' => 'Subcategories', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Subcategories', 'sub_title' => 'Tables'])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Subcategories</h4>
                    <!-- Add subcategory Button -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addsubcategoryModal">
                        <i class="fas fa-plus"></i> Add Subcategory
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subcategories as $subsubcategory)
                            <tr>
                                <td>{{ $subsubcategory->id }}</td>
                                <td>
                                    @if($subsubcategory->logo)
                                        <img src="{{ asset('storage/' . $subsubcategory->logo) }}" alt="Logo" width="50">
                                    @else
                                        <span>No Logo</span>
                                    @endif
                                </td>
                                <td>{{ $subsubcategory->name }}</td>
                                <td>{{ $subsubcategory->slug }}</td>
                                <td>{{ $subsubcategory->category->name ?? 'No Category' }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editsubcategoryModal{{ $subsubcategory->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.subcategories.destroy', $subsubcategory->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subcategory?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Subcategory Modal -->
                            <div class="modal fade" id="editsubcategoryModal{{ $subsubcategory->id }}" tabindex="-1" aria-labelledby="editsubcategoryLabel{{ $subsubcategory->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Subcategory</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.subcategories.update', $subsubcategory->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id" class="form-control" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $subsubcategory->category_id == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $subsubcategory->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Slug</label>
                                                    <input type="text" class="form-control" name="slug" value="{{ $subsubcategory->slug }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Logo</label>
                                                    <input type="file" class="form-control" name="logo" accept="image/*">
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
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add Subcategory Modal -->
<div class="modal fade" id="addsubcategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Subcategory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subcategory</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<script>
$(document).ready(function() {
    $('#categoriesTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>

@endsection
