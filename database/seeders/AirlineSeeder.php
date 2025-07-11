<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;

class AirlineSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            ['code' => 'AirCan',   'name' => 'Air Canada',     'country' => 'Canada'],
            ['code' => 'USAir',    'name' => 'US Airlines',     'country' => 'USA'],
            ['code' => 'BritAir',  'name' => 'British Airways', 'country' => 'UK'],
            ['code' => 'AirFrance','name' => 'Air France',      'country' => 'France'],
            ['code' => 'LuftAir',  'name' => 'Lufthansa',       'country' => 'Germany'],
            ['code' => 'ItalAir',  'name' => 'Alitalia',        'country' => 'Italy'],
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}
