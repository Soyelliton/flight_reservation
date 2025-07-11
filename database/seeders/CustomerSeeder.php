<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\MailingAddress;
use App\Models\ContactInfo;
use App\Models\Booking;
use App\Models\Flight;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $address = MailingAddress::create([
            'street' => '123 Main Street',
            'city' => 'New York',
            'state_or_province' => 'NY',
            'postal_code' => '10001',
            'country' => 'USA',
        ]);

        $customer = Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'mailing_address_id' => $address->id,
        ]);

        ContactInfo::create([
            'customer_id' => $customer->id,
            'type' => 'email',
            'value' => 'john.doe@example.com',
        ]);

        ContactInfo::create([
            'customer_id' => $customer->id,
            'type' => 'phone',
            'value' => '1234567890',
            'country_code' => '+1',
            'area_code' => '212',
            'local_number' => '1234567',
        ]);

        $flight = Flight::inRandomOrder()->first();
        $departure = Carbon::tomorrow()->addHours(10);
        $arrival = $departure->copy()->addHours(6);
        $base_price = 300;

        $total_price = $base_price + 50 + 70; // price + origin tax + destination tax
        $class = 'business';
        if ($class === 'business') {
            $total_price = ($base_price * 1.5) + 50 + 70;
        }

        Booking::create([
            'booking_no' => uniqid('BK'),
            'city' => 'New York',
            'booking_date' => Carbon::now()->toDateString(),
            'flight_id' => $flight->id,
            'departure_datetime' => $departure,
            'arrival_datetime' => $arrival,
            'class' => $class,
            'status' => 'booked',
            'price' => $total_price,
            'amount_paid' => 200,
            'balance' => $total_price - 200,
            'passenger_name' => 'John Doe',
            'customer_id' => $customer->id,
        ]);
    }
}
