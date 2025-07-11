<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'mailing_address_id'];

    public function mailingAddress()
    {
        return $this->belongsTo(MailingAddress::class);
    }

    public function contactInfos()
    {
        return $this->hasMany(ContactInfo::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
