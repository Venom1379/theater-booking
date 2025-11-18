@extends('layouts.vertical', ['title'=>'Shows'])

@section('content')
@include('layouts.shared.page-title', ['page_title'=>'Show List'])

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShowModal">+ Add Show</button>
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
                                        <th>Theater</th>
                                        <th>Name</th>
                                        <th>Event</th>
                                        <th>Show Date</th>
                                        <th>Slots</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="theatersTableBody">
                                   @foreach($shows as $key=>$show)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $show->theater->name }}</td>
                <td>{{ $show->name }}</td>
                <td>{{ $show->event_name }}</td>
                <td>{{ $show->show_date }}</td>
                <td>
                    @foreach($show->slots as $slot)
                        {{ $slot->slot_name }} ({{ $slot->start_time }}-{{ $slot->end_time }})<br>
                    @endforeach
                </td>
                <td>
                    <button class="btn btn-warning btn-sm editBtn"
                        data-id="{{ $show->id }}"
                        data-theater="{{ $show->theater_id }}"
                        data-name="{{ $show->name }}"
                        data-event="{{ $show->event_name }}"
                        data-date="{{ $show->show_date }}"
                    >Edit</button>

                    <form action="{{ route('admin.shows.destroy', $show->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
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
   

</div>

<!-- ADD SHOW MODAL -->
<div class="modal fade" id="addShowModal">
    <div class="modal-dialog">
        <form action="{{ route('admin.shows.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Show</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Theater</label>
                        <select name="theater_id" class="form-control" required>
                            <option value="">Select Theater</option>
                            @foreach($theaters as $theater)
                                <option value="{{ $theater->id }}">{{ $theater->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Show Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2 d-none">
                        <label>Event Name</label>
                        <input type="text" name="event_name" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Show Date</label>
                        <input type="date" name="show_date" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- EDIT SHOW MODAL -->
<div class="modal fade" id="editShowModal">
    <div class="modal-dialog">
        <form id="editShowForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Show</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Theater</label>
                        <select name="theater_id" class="form-control edit_theater" required>
                            <option value="">Select Theater</option>
                            @foreach($theaters as $theater)
                                <option value="{{ $theater->id }}">{{ $theater->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Show Name</label>
                        <input type="text" name="name" class="form-control edit_name" required>
                    </div>
                    <div class="mb-2">
                        <label>Event Name</label>
                        <input type="text" name="event_name" class="form-control edit_event">
                    </div>
                    <div class="mb-2">
                        <label>Show Date</label>
                        <input type="date" name="show_date" class="form-control edit_date" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('#showTable').DataTable();

    $(".editBtn").click(function(){
        let id = $(this).data('id');
        $("#editShowForm").attr("action", "/admin/shows/" + id);
        $(".edit_theater").val($(this).data('theater'));
        $(".edit_name").val($(this).data('name'));
        $(".edit_event").val($(this).data('event'));
        $(".edit_date").val($(this).data('date'));
        $("#editShowModal").modal('show');
    });
});
</script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@endpush
