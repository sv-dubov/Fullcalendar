<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_time', 'end_time', 'is_booked'];

    public $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];
}
