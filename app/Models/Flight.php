<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_number',
        'airline_id',
        'business_class',
        'smoking_allowed',
        'origin_city_id',
        'destination_city_id',
        'price'
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }
}
