<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'available_parking_space_id',
        'car_brand',
        'car_model',
        'license_plate',
        'is_confirmed',
        'confirmed_by',
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function space()
    {
        return $this->belongsTo(AvailableParkingSpace::class, 'available_parking_space_id');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}

