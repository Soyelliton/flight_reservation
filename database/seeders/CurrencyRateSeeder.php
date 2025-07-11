<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CurrencyRate;
use Carbon\Carbon;

class CurrencyRateSeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['currency_code' => 'CAD', 'rate_to_usd' => 0.75],
            ['currency_code' => 'USD', 'rate_to_usd' => 1.00],
            ['currency_code' => 'GBP', 'rate_to_usd' => 1.25],
            ['currency_code' => 'FRF', 'rate_to_usd' => 0.17],
            ['currency_code' => 'DEM', 'rate_to_usd' => 0.58],
            ['currency_code' => 'LIR', 'rate_to_usd' => 0.00052],
        ];

        foreach ($currencies as $currency) {
            CurrencyRate::create([
                'currency_code' => $currency['currency_code'],
                'rate_to_usd' => $currency['rate_to_usd'],
                'rate_date' => Carbon::today(),
            ]);
        }
    }
}
