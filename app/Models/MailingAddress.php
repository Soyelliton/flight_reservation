<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'city',
        'state_or_province',
        'postal_code',
        'country',
    ];

    /**
     * Get the customers associated with this mailing address.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
