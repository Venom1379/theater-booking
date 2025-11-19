@extends('front.layouts.vertical', ['title'=>'Shows'])

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .calendar-grid { display:grid; grid-template-columns: repeat(7,1fr); gap:12px; }
    .calendar-day { background:#fff; border-radius:10px; padding:10px; min-height:110px; border:1px solid #e6e6e6; }
    .day-number { font-weight:700; margin-bottom:6px; }
    .slot-row { margin-top:6px; padding:6px; border-radius:6px; font-size:13px; display:flex; justify-content:space-between; align-items:center; }
    .slot-available { background:#a7f3d0; color:#064e3b; cursor:pointer; }    /* green-ish */
    .slot-user { background:#bfdbfe; color:#1e3a8a; cursor:pointer; }         /* blue for current user */
    .slot-other { background:#fed7aa; color:#7c2d12; cursor:pointer; }        /* orange for other users */
    .slot-full { background:#fca5a5; color:#7f1d1d; }                        /* red-ish for full (>=3) */
    .slot-disabled { opacity:0.6; cursor:not-allowed; }
    .controls { display:flex; gap:8px; align-items:center; margin-bottom:16px; }
</style>

<div class="container py-4">
    <h3 class="mb-3">Book Theater Slots (90-day calendar)</h3>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Select Theater</label>
            <select id="theaterSelect" class="form-select">
                @foreach($theaters as $t)
                    <option value="{{ $t->id }}" {{ $t->id == $defaultTheater ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-8 d-flex align-items-end justify-content-end">
            <div class="controls">
                <button id="prevBtn" class="btn btn-outline-primary btn-sm">Prev</button>
                <div id="currentRange" class="px-2"></div>
                <button id="nextBtn" class="btn btn-outline-primary btn-sm">Next</button>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div id="calendarWrapper">
        <!-- calendar injected here -->
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="bookingForm">
        <div class="modal-header">
          <h5 class="modal-title">Book Slot</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div><strong>Theater:</strong> <span id="modalTheater"></span></div>
            <div><strong>Date:</strong> <span id="modalDate"></span></div>
            <div><strong>Slot:</strong> <span id="modalSlotName"></span></div>
            <div><strong>Time:</strong> <span id="modalSlotTime"></span></div>
            <div><strong>Price:</strong> ₹ <span id="modalSlotPrice"></span></div>
            <div id="modalNotice" class="mt-2 text-danger"></div>
            <input type="hidden" id="modalTheaterId" name="theater_id">
            <input type="hidden" id="modalSlotId" name="slot_id">
            <input type="hidden" id="modalDateInput" name="booking_date">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="modalBookBtn" type="submit" class="btn btn-primary">Confirm Booking</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS (for modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/*
 Frontend logic:
  - loads slots and bookings for a 90-day window (startDate -> startDate + 89 days)
  - default startDate = today
  - prev/next shift startDate by 30 days but clamp to [today, today+89]
  - render each day; for each slot show color according to counts:
     - if count >= 3 => slot-full
     - else if current user has booking (user_id === currentUserId) => slot-user
     - else if count >= 1 => slot-other
     - else => slot-available
  - click on slot (available, user, other but not full) opens modal with details and book button (disabled if already own or full)
*/

const userId = {{ auth()->check() ? auth()->id() : 'null' }}; // JS current user id
let startDate = new Date(); // default: today
startDate.setHours(0,0,0,0);

const MS_PER_DAY = 24 * 60 * 60 * 1000;
const MAX_DAYS = 90; // 90-day cycle

// clamp helper
function clampDate(d) {
    const today = new Date(); today.setHours(0,0,0,0);
    const max = new Date(today.getTime() + (MAX_DAYS-1) * MS_PER_DAY);
    if (d < today) return today;
    if (d > max) return max;
    return d;
}

function formatDateYMD(d) {
    const y = d.getFullYear();
    const m = String(d.getMonth()+1).padStart(2,'0');
    const day = String(d.getDate()).padStart(2,'0');
    return `${y}-${m}-${day}`;
}

function addDays(d, days) {
    const n = new Date(d.getTime());
    n.setDate(n.getDate() + days);
    return n;
}

document.getElementById('prevBtn').addEventListener('click', () => {
    startDate = addDays(startDate, -30);
    startDate = clampDate(startDate);
    loadAndRender();
});
document.getElementById('nextBtn').addEventListener('click', () => {
    startDate = addDays(startDate, 30);
    startDate = clampDate(startDate);
    loadAndRender();
});

document.getElementById('theaterSelect').addEventListener('change', () => {
    // Reset startDate to today when theater changed to be safe
    startDate = clampDate(new Date());
    loadAndRender();
});

let cachedSlots = []; // array of slots metadata
let cachedBookings = []; // array of bookings within the window

async function loadAndRender() {
    const theaterId = document.getElementById('theaterSelect').value;
    if (!theaterId) {
        document.getElementById('calendarWrapper').innerHTML = '<div class="alert alert-warning">Please select a theater</div>';
        return;
    }

    // format dates
    const startStr = formatDateYMD(startDate);

    // show current range
    const endDate = addDays(startDate, MAX_DAYS - 1);
    document.getElementById('currentRange').innerText = `${startStr} → ${formatDateYMD(endDate)}`;

    // fetch slots + bookings
    const url = `{{ route('booking.getData') }}?theater_id=${theaterId}&start_date=${startStr}`;
    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if (!res.ok) {
        document.getElementById('calendarWrapper').innerHTML = '<div class="alert alert-danger">Failed to fetch data</div>';
        return;
    }
    const json = await res.json();
    cachedSlots = json.slots;
    cachedBookings = json.bookings;

    renderCalendar(cachedSlots, cachedBookings);
}

function renderCalendar(slots, bookings) {
    // show 90 days in grid with 7 columns per row (like calendar 7-day week)
    let html = '';

    // header: week day labels
    const weekLabels = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    html += `<div class="calendar-grid mb-2">`;
    weekLabels.forEach(w => html += `<div class="text-center fw-semibold">${w}</div>`);
    html += `</div>`;

    // We'll build rows of 7 days. Find day-of-week of startDate to offset first row.
    const startDay = startDate.getDay(); // 0..6
    // Build a 90-day sequence
    html += `<div class="calendar-grid">`;

    // add empty grid items for offset
    for (let i = 0; i < startDay; i++) {
        html += `<div></div>`;
    }

    for (let i = 0; i < MAX_DAYS; i++) {
        const dayDate = addDays(startDate, i);
        const dateStr = formatDateYMD(dayDate);
        console.log('dateStr', dateStr);
        console.log('booking_dates', bookings.map(b => b.booking_date));
        
        

        // bookings for this date
        // const dayBookings = bookings.filter(b => b.booking_date === dateStr);
        const dayBookings = bookings.filter(b => normalizeDate(b.booking_date) === dateStr);
        console.log('dayBookings', dayBookings);
        

        // date box
        html += `<div class="calendar-day">`;
        html += `<div class="day-number">${dateStr}</div>`;

        // for each slot show a row
        slots.forEach(slot => {
            const slotBookings = dayBookings.filter(b => b.slot_id == slot.id);
            console.log('slotBookings', slotBookings);
            
            const count = slotBookings.length;

            let cls = 'slot-available';
            let disabled = false;
            let title = `${slot.slot_name} - ${slot.start_time} to ${slot.end_time} - ₹${slot.price}`;

            // color rules:
            // if any booking by current user exists for this slot/date -> slot-user (blue)
            // else if count >= 3 -> slot-full (red-ish)
            // else if count >= 1 -> slot-other (orange)
            // else available (green)
            const userHas = slotBookings.some(b => b.user_id === userId);
            if (count >= 3) {
                cls = 'slot-full slot-disabled';
                disabled = true;
            } else if (userHas) {
                cls = 'slot-user';
            } else if (count >= 1) {
                cls = 'slot-other';
            } else {
                cls = 'slot-available';
            }

            // build slot HTML - include data attributes for modal
            const slotHtml = `<div class="slot-row ${cls} ${disabled ? 'slot-disabled' : ''}"
                                 data-slot-id="${slot.id}" data-slot-name="${slot.slot_name}"
                                 data-slot-start="${slot.start_time}" data-slot-end="${slot.end_time}"
                                 data-slot-price="${slot.price}" data-date="${dateStr}"
                                 onclick="onSlotClick(this)">
                                 <div style="font-weight:600">${slot.slot_name}</div>
                                 <div style="font-size:12px">${slot.start_time} - ${slot.end_time}</div>
                              </div>`;

            html += slotHtml;
        });

        html += `</div>`;
    }

    // fill remaining cells to complete last week row
    const totalCells = startDay + MAX_DAYS;
    const remainder = totalCells % 7;
    if (remainder !== 0) {
        const empty = 7 - remainder;
        for (let e = 0; e < empty; e++) html += `<div></div>`;
    }

    html += `</div>`; // close calendar-grid

    document.getElementById('calendarWrapper').innerHTML = html;
}
function normalizeDate(dateString) {
    return dateString.split("T")[0]; // take only yyyy-mm-dd
}
/* slot click handler - opens modal */
function onSlotClick(el) {
    // if disabled do nothing
    if (el.classList.contains('slot-disabled')) {
        // but still allow clicking if it's user's booking (so they can see details)
        if (!el.classList.contains('slot-user')) return;
    }

    const theaterSel = document.getElementById('theaterSelect');
    const theaterId = theaterSel.value;
    const theaterName = theaterSel.options[theaterSel.selectedIndex].text;

    const slotId = el.getAttribute('data-slot-id');
    const slotName = el.getAttribute('data-slot-name');
    const slotStart = el.getAttribute('data-slot-start');
    const slotEnd = el.getAttribute('data-slot-end');
    const slotPrice = el.getAttribute('data-slot-price');
    const date = el.getAttribute('data-date');

    // populate modal
    document.getElementById('modalTheater').innerText = theaterName;
    document.getElementById('modalDate').innerText = date;
    document.getElementById('modalSlotName').innerText = slotName;
    document.getElementById('modalSlotTime').innerText = `${slotStart} - ${slotEnd}`;
    document.getElementById('modalSlotPrice').innerText = slotPrice;
    document.getElementById('modalTheaterId').value = theaterId;
    document.getElementById('modalSlotId').value = slotId;
    document.getElementById('modalDateInput').value = date;
    document.getElementById('modalNotice').innerText = '';

    // determine if user already booked this slot/date
    const isUserBooking = cachedBookings.some(b => b.booking_date === date && b.slot_id == slotId && b.user_id === userId);
    const countForSlot = cachedBookings.filter(b => b.booking_date === date && b.slot_id == slotId).length;

    const bookBtn = document.getElementById('modalBookBtn');
    if (isUserBooking) {
        // disable booking (already booked)
        bookBtn.disabled = true;
        document.getElementById('modalNotice').innerText = 'You already booked this slot on this date.';
    } else if (countForSlot >= 3) {
        bookBtn.disabled = true;
        document.getElementById('modalNotice').innerText = 'Slot is full (3 bookings reached).';
    } else {
        bookBtn.disabled = false;
        document.getElementById('modalNotice').innerText = '';
    }

    // show modal
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
}

/* booking form submit */
document.getElementById('bookingForm').addEventListener('submit', async function(e){
    e.preventDefault();

    // ensure logged in
    if (!userId) {
        alert('Please login to book.');
        return;
    }

    const theater_id = document.getElementById('modalTheaterId').value;
    const slot_id = document.getElementById('modalSlotId').value;
    const booking_date = document.getElementById('modalDateInput').value;

    const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';

    const res = await fetch("{{ route('booking.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ theater_id, slot_id, booking_date })
    });

    const json = await res.json();
    if (!res.ok || !json.status) {
        alert(json.message || 'Booking failed');
    } else {
        alert(json.message || 'Booked successfully');
        // hide modal
        const modalEl = document.getElementById('bookingModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
        // reload cached bookings and rerender
        await loadAndRender();
    }
});

// initial load
document.addEventListener('DOMContentLoaded', () => {
    // ensure startDate clamped
    startDate = clampDate(startDate);
    loadAndRender();
});
</script>

@endsection
