<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\FlightAvailability;
use App\Models\Airline;
use App\Models\City;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = Airline::all()->keyBy('code');
        $cities = City::all()->keyBy('name');

        $flights = [
            // Canada
            ['flight_number' => 'AC100', 'airline_code' => 'AirCan',   'business_class' => true, 'smoking_allowed' => false, 'origin' => 'Toronto', 'destination' => 'Montreal', 'price' => 400],
            // USA
            ['flight_number' => 'UA200', 'airline_code' => 'USAir',    'business_class' => true, 'smoking_allowed' => false, 'origin' => 'New York', 'destination' => 'Chicago', 'price' => 350],
            // UK
            ['flight_number' => 'BA300', 'airline_code' => 'BritAir',  'business_class' => true, 'smoking_allowed' => false, 'origin' => 'London', 'destination' => 'Edinburgh', 'price' => 300],
            // France
            ['flight_number' => 'AF400', 'airline_code' => 'AirFrance','business_class' => true, 'smoking_allowed' => false, 'origin' => 'Paris', 'destination' => 'Nice', 'price' => 320],
            // Germany
            ['flight_number' => 'LH500', 'airline_code' => 'LuftAir',  'business_class' => true, 'smoking_allowed' => false, 'origin' => 'Berlin', 'destination' => 'Bonn', 'price' => 310],
            // Italy
            ['flight_number' => 'AZ600', 'airline_code' => 'ItalAir',  'business_class' => true, 'smoking_allowed' => false, 'origin' => 'Rome', 'destination' => 'Naples', 'price' => 330],
        ];

        foreach ($flights as $f) {
            $flight = Flight::create([
                'flight_number'     => $f['flight_number'],
                'airline_id'        => $airlines[$f['airline_code']]->id,
                'business_class'    => $f['business_class'],
                'smoking_allowed'   => $f['smoking_allowed'],
                'origin_city_id'    => $cities[$f['origin']]->id,
                'destination_city_id' => $cities[$f['destination']]->id,
                'price'             => $f['price'],
            ]);

            // Add flight availability
            FlightAvailability::create([
                'flight_id' => $flight->id,
                'departure_datetime' => Carbon::tomorrow()->addHours(rand(5, 22)),
                'seats_business_total' => 30,
                'seats_business_booked' => rand(0, 10),
                'seats_economy_total' => 100,
                'seats_economy_booked' => rand(0, 50),
            ]);
        }
    }
}
