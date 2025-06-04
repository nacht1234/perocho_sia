<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableParkingSpace extends Model
{
    protected $fillable = [
        'bldg_floor_no', 
        'lot_no', 
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
