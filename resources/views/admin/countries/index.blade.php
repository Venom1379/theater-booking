@extends('layouts.vertical', ['title' => 'Countries'])
@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
@include('layouts.shared.page-title', ['page_title' => 'Countries', 'sub_title' => 'Tables'])

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Countries</h4>
                    <!-- Add Country Button -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                        <i class="fas fa-plus"></i> Add Country
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0" id="countriesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($countries as $country)
                            <tr>
                                <td>{{ $country->id }}</td>
                                <td>{{ $country->name }}</td>
                                <td>{{ $country->code }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCountryModal{{ $country->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this country?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Edit Country Modal -->
                            <div class="modal fade" id="editCountryModal{{ $country->id }}" tabindex="-1" aria-labelledby="editCountryLabel{{ $country->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCountryLabel{{ $country->id }}">Edit Country</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.countries.update', $country->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name{{ $country->id }}" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name{{ $country->id }}" name="name" value="{{ $country->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="code{{ $country->id }}" class="form-label">Code</label>
                                                    <input type="text" class="form-control" id="code{{ $country->id }}" name="code" value="{{ $country->code }}" required>
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

<!-- Add Country Modal -->
<div class="modal fade" id="addCountryModal" tabindex="-1" aria-labelledby="addCountryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCountryLabel">Add Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.countries.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Country</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#countriesTable').DataTable({
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