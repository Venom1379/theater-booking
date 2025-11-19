<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_date',
        'slot_id',
        'theater_id',
        'user_id',
        'program_name',
        'vip_present',
        'vip_name',
        'previous_fund_allocated',
        'funding_details',
        'nature_of_admission',
        'artist_participation',
        'program_incharge',
        'program_incharge_phone',
        'program_nature',
        'booking_nature',
        'status',
        'price',
    ];

    protected $casts = [
        'vip_present' => 'boolean',
        'previous_fund_allocated' => 'boolean',
        'booking_date' => 'date',
        'price' => 'integer',
    ];

    /* -------------------------
       Relationships
    --------------------------*/

    // User who did booking
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Theater relationship
    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    // Slot relationship
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
