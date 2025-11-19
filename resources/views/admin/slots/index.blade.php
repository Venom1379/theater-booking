@extends('layouts.vertical', ['title'=>'Shows'])

@section('content')
@include('layouts.shared.page-title', ['page_title'=>'Show List'])


<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Slots</h3>
        <div>
            <button id="addRowBtn" type="button" class="btn btn-success">Add Row</button>
        </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.slots.saveAll') }}" id="slotsForm">
        @csrf

        <!-- will collect ids of removed existing rows -->
        <div id="deleted-holder"></div>

        <table class="table table-bordered" id="slotsTable">
            <thead>
                <tr>
                    <th>Slot Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width:110px">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($slots as $slot)
                    <tr data-row-id="{{ $slot->id }}">
                        <!-- keep id to match rows on submit -->
                        <input type="hidden" name="id[]" value="{{ $slot->id }}">

                        <td>
                            <input type="text" name="slot_name[]" class="form-control" value="{{ $slot->slot_name }}" required>
                        </td>

                        <td>
                            <input type="time" name="start_time[]" class="form-control" value="{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}" required>
                        </td>

                        <td>
                            <input type="time" name="end_time[]" class="form-control" value="{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}" required>
                        </td>

                        <td>
                            <input type="number" name="price[]" step="0.01" class="form-control" value="{{ $slot->price }}" required>
                        </td>

                        <td>
                            <select name="status[]" class="form-select">
                                <option value="active" {{ $slot->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="cancelled" {{ $slot->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="archived" {{ $slot->status == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeRowBtn">Remove</button>
                        </td>
                    </tr>
                @empty
                    <!-- show one empty row if no data -->
                    <tr>
                        <input type="hidden" name="id[]" value="">
                        <td><input type="text" name="slot_name[]" class="form-control" required></td>
                        <td><input type="time" name="start_time[]" class="form-control" required></td>
                        <td><input type="time" name="end_time[]" class="form-control" required></td>
                        <td><input type="number" name="price[]" step="0.01" class="form-control" required></td>
                        <td>
                            <select name="status[]" class="form-select">
                                <option value="active">Active</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="archived">Archived</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRowBtn">Remove</button></td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save All</button>
        </div>
    </form>
</div>

<!-- Templates for JS to append new rows -->
<table style="display:none">
    <tbody id="row-template">
        <tr>
            <input type="hidden" name="id[]" value="">
            <td><input type="text" name="slot_name[]" class="form-control" required></td>
            <td><input type="time" name="start_time[]" class="form-control" required></td>
            <td><input type="time" name="end_time[]" class="form-control" required></td>
            <td><input type="number" name="price[]" step="0.01" class="form-control" required></td>
            <td>
                <select name="status[]" class="form-select">
                    <option value="active">Active</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="archived">Archived</option>
                </select>
            </td>
            <td><button type="button" class="btn btn-danger btn-sm removeRowBtn">Remove</button></td>
        </tr>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('addRowBtn');
    const tbody = document.querySelector('#slotsTable tbody');
    const rowTpl = document.querySelector('#row-template').innerHTML;
    const deletedHolder = document.getElementById('deleted-holder');

    // Add new blank row
    addBtn.addEventListener('click', function () {
        tbody.insertAdjacentHTML('beforeend', rowTpl);
    });

    // Delegate remove button (works for existing and new rows)
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('removeRowBtn')) {
            const tr = e.target.closest('tr');
            if (!tr) return;

            const existingIdInput = tr.querySelector('input[name="id[]"]');
            if (existingIdInput && existingIdInput.value) {
                // This was an existing DB row — add a deleted_ids[] hidden input
                const deletedInput = document.createElement('input');
                deletedInput.type = 'hidden';
                deletedInput.name = 'deleted_ids[]';
                deletedInput.value = existingIdInput.value;
                deletedHolder.appendChild(deletedInput);
            }
            // Remove row from DOM
            tr.remove();
        }
    });

    // Optional: simple client-side check to ensure at least 1 row exists before submit
    const form = document.getElementById('slotsForm');
    form.addEventListener('submit', function (e) {
        const rows = tbody.querySelectorAll('tr');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Add at least one slot row before saving.');
        }
    });
});
</script>

@endsection
