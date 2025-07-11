<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'value',
        'country_code',
        'area_code',
        'local_number'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
