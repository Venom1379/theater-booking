<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Slot;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // Show booking page (pass theaters and default)
    public function index()
    {
        $theaters = Theater::all();
        $defaultTheater = $theaters->first()->id ?? null;
        return view('front.index', compact('theaters','defaultTheater'));
    }

    /**
     * Returns:
     *  - slots => list of active slots (slot metadata)
     *  - bookings => bookings within requested range
     * Accepts query params:
     *  - theater_id (required)
     *  - start_date (Y-m-d) optional -> default today
     */
    public function getData(Request $request)
    {
        $request->validate([
            'theater_id' => 'required|exists:theaters,id',
            'start_date' => 'nullable|date',
        ]);

        $theaterId = $request->theater_id;
        $start = $request->start_date ? Carbon::parse($request->start_date) : Carbon::today();
        $start->startOfDay();
        $end = (clone $start)->addDays(89)->endOfDay(); // 90 days total (start + 89 days)

        // Fetch active slots
        $slots = Slot::where('status','active')->orderBy('id')->get(['id','slot_name','start_time','end_time','price']);

        // fetch bookings for the theater within range
        $bookings = Booking::where('theater_id',$theaterId)
            ->whereBetween('booking_date', [$start->toDateString(), $end->toDateString()])
            ->get();

        return response()->json([
            'slots' => $slots,
            'bookings' => $bookings,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ]);
    }

    /**
     * Store booking:
     * - user cannot book same slot+date twice
     * - max 3 bookings per slot+date across users
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status'=>false,'message'=>'Login required'], 401);
        }

        $request->validate([
            'theater_id' => ['required','exists:theaters,id'],
            'slot_id' => ['required','exists:slots,id'],
            'booking_date' => ['required','date'],
        ]);

        $theaterId = $request->theater_id;
        $slotId = $request->slot_id;
        $date = Carbon::parse($request->booking_date)->toDateString();

        // check 90-day window
        $today = Carbon::today();
        $maxDate = Carbon::today()->addDays(89);
        if (Carbon::parse($date)->lt($today) || Carbon::parse($date)->gt($maxDate)) {
            return response()->json(['status'=>false,'message'=>'Booking date must be within next 90 days'], 422);
        }

        // prevent duplicate booking by same user for same slot+date
        $exists = Booking::where('user_id', $user->id)
            ->where('theater_id', $theaterId)
            ->where('slot_id', $slotId)
            ->where('booking_date', $date)
            ->exists();

        if ($exists) {
            return response()->json(['status'=>false,'message'=>'You have already booked this slot on that date'], 422);
        }

        // count total bookings for that slot+date
        $count = Booking::where('theater_id', $theaterId)
            ->where('slot_id', $slotId)
            ->where('booking_date', $date)
            ->count();

        if ($count >= 3) {
            return response()->json(['status'=>false,'message'=>'Slot is full (3 bookings reached)'], 422);
        }

        // get slot price
        $slot = Slot::findOrFail($slotId);

        $booking = Booking::create([
            'theater_id' => $theaterId,
            'slot_id' => $slotId,
            'booking_date' => $date,
            'user_id' => $user->id,
            'status' => 'pending', // admin can approve later
            'price' => $slot->price,
        ]);

        return response()->json(['status'=>true,'message'=>'Booking successful','booking'=>$booking]);
    }
}
