<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    protected $fillable = ['currency_code', 'rate_to_usd', 'rate_date'];

    protected $casts = [
        'rate_to_usd' => 'decimal:4',
        'rate_date' => 'date'
    ];
}
