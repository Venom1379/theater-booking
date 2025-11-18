<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  // ✅ FIXED IMPORT

class Theater extends Model
{
    use HasFactory, SoftDeletes;   // ✅ Works now

    protected $fillable = ['name', 'location', 'capacity'];
}
