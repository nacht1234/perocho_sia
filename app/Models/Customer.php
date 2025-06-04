<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'name', 
        'age', 
        'gender', 
        'phone',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

