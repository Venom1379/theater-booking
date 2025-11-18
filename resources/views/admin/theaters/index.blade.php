@extends('layouts.vertical', ['title' => 'Theaters'])

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Theater List'])

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Theater</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

       <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Capacity</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="theatersTableBody">
                                    @foreach($theaters as $key => $t)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $t->name }}</td>
                <td>{{ $t->location }}</td>
                <td>{{ $t->capacity }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn"
                        data-id="{{ $t->id }}"
                        data-name="{{ $t->name }}"
                        data-location="{{ $t->location }}"
                        data-capacity="{{ $t->capacity }}"
                        >Edit</button>

                    <form action="{{ route('admin.theaters.destroy',$t->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
 

</div>


<!-- ============== ADD MODAL ============== -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.theaters.store') }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Theater</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Capacity</label>
                        <input type="number" name="capacity" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>


<!-- ============== EDIT MODAL ============== -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            @csrf
            @method("PUT")

            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Theater</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control edit_name">
                    </div>

                    <div class="mb-2">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control edit_location">
                    </div>

                    <div class="mb-2">
                        <label>Capacity</label>
                        <input type="number" name="capacity" class="form-control edit_capacity">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- make sure jQuery is loaded in your layout BEFORE this stack -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    var baseUrl = "{{ url('admin/theaters') }}";

    // quick console sanity
    $(document).on('click', '.editBtn', function (e) {
        e.preventDefault();

        // debug logs
        console.log('Edit button clicked', this);

        var id = $(this).data('id');
        var name = $(this).data('name');
        var location = $(this).data('location');
        var capacity = $(this).data('capacity');

        if (!id) {
            console.error('No ID found on clicked editBtn');
            return;
        }

        // set form action: /admin/theaters/{id}
        $('#editForm').attr('action', baseUrl + '/' + id);

        // populate fields
        $('.edit_name').val(name);
        $('.edit_location').val(location);
        $('.edit_capacity').val(capacity);

        // show modal
        $('#editModal').modal('show');
    });
    if (typeof $ === 'undefined') {
        console.error('jQuery not found. Make sure jQuery is loaded before these scripts.');
        return;
    }

    // init datatable
    $('#theaterTable').DataTable();

    // base url for update (no trailing slash)
    
    // use event delegation so it works even when rows are refreshed
   
});
</script>



@endsection
