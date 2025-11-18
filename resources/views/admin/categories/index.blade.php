@extends('layouts.vertical', ['title' => 'Categories', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])
@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Categories', 'sub_title' => 'Tables'])
<!-- FontAwesome -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Categories</h4>
                    <!-- Add Category Button -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0" id="categoriesTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Logo</th>

                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @if($category->logo)
                                        <img src="{{ asset('storage/' . $category->logo) }}" alt="Logo" width="50">
                                    @else
                                        <span>No Logo</span>
                                    @endif
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Category Modal -->
                            <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCategoryLabel{{ $category->id }}">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name{{ $category->id }}" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="slug{{ $category->id }}" class="form-label">Slug</label>
                                                    <input type="text" class="form-control" id="slug{{ $category->id }}" name="slug" value="{{ $category->slug }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="logo{{ $category->id }}" class="form-label">Logo</label>
                                                    <input type="file" class="form-control" id="logo{{ $category->id }}" name="logo" accept="image/*">
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- @section('scripts') --}}
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- DataTables JS (Must come after jQuery) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    console.log("jQuery Version:", $.fn.jquery);
console.log("DataTables Defined?", typeof $.fn.DataTable !== "undefined" ? "YES" : "NO");


    // Initialize DataTables after confirming it's loaded
    if ($.fn.DataTable) {
        console.log("✅ Initializing DataTables...");
        $('#categoriesTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    } else {
        console.error("❌ DataTables still not available!");
    }
});
</script>
{{-- @endsection --}}

@endsection

