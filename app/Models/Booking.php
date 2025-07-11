<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_no',
        'city',
        'booking_date',
        'flight_id',
        'departure_datetime',
        'arrival_datetime',
        'class',
        'status',
        'price',
        'amount_paid',
        'balance',
        'passenger_name',
        'customer_id'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'departure_datetime' => 'datetime',
        'arrival_datetime' => 'datetime',
        'price' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance' => 'decimal:2'
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
