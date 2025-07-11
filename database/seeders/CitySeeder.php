<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Toronto',    'country' => 'Canada', 'state_province' => 'Ontario', 'airport_tax' => 50, 'currency_code' => 'CAD'],
            ['name' => 'Montreal',   'country' => 'Canada', 'state_province' => 'Quebec', 'airport_tax' => 45, 'currency_code' => 'CAD'],
            ['name' => 'New York',   'country' => 'USA', 'state_province' => 'New York', 'airport_tax' => 60, 'currency_code' => 'USD'],
            ['name' => 'Chicago',    'country' => 'USA', 'state_province' => 'Illinois', 'airport_tax' => 55, 'currency_code' => 'USD'],
            ['name' => 'London',     'country' => 'UK', 'state_province' => 'England', 'airport_tax' => 70, 'currency_code' => 'GBP'],
            ['name' => 'Edinburgh',  'country' => 'UK', 'state_province' => 'Scotland', 'airport_tax' => 65, 'currency_code' => 'GBP'],
            ['name' => 'Paris',      'country' => 'France', 'state_province' => 'Île-de-France', 'airport_tax' => 80, 'currency_code' => 'FRF'],
            ['name' => 'Nice',       'country' => 'France', 'state_province' => 'Provence-Alpes-Côte d\'Azur', 'airport_tax' => 75, 'currency_code' => 'FRF'],
            ['name' => 'Berlin',     'country' => 'Germany', 'state_province' => 'Berlin', 'airport_tax' => 68, 'currency_code' => 'DEM'],
            ['name' => 'Bonn',       'country' => 'Germany', 'state_province' => 'North Rhine-Westphalia', 'airport_tax' => 66, 'currency_code' => 'DEM'],
            ['name' => 'Rome',       'country' => 'Italy', 'state_province' => 'Lazio', 'airport_tax' => 90, 'currency_code' => 'LIR'],
            ['name' => 'Naples',     'country' => 'Italy', 'state_province' => 'Campania', 'airport_tax' => 85, 'currency_code' => 'LIR'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
