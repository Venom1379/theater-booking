<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'theater_id',
        'name',
        'event_name',
        'show_date',
        'status',
    ];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}
