<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\CurrencyRate;
use App\Models\City;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['flight.airline', 'flight.originCity', 'flight.destinationCity', 'customer'])->get();
        $bookings = $bookings->map(function($booking) {
            $flight = $booking->flight;
            $origin = $flight->originCity;
            $destination = $flight->destinationCity;
            $origin_tax = $origin ? $origin->airport_tax : 0;
            $destination_tax = $destination ? $destination->airport_tax : 0;
            $currency_code = $origin ? $origin->currency_code : 'USD';
            $flight_price = $flight ? $flight->price : 0;
            if ($booking->class === 'business') {
                $flight_price = $flight_price * 1.5;
            }
            $rate = CurrencyRate::where('currency_code', $currency_code)
                ->whereDate('rate_date', $booking->booking_date)
                ->orderByDesc('rate_date')
                ->first();
            $rate_to_usd = $rate ? $rate->rate_to_usd : 1;
            $total_price_local = $rate_to_usd > 0 ? ($origin_tax + $destination_tax + $flight_price) / $rate_to_usd : null;
            $booking->local_currency = $currency_code;
            $booking->total_price_local = $total_price_local ? round($total_price_local, 2) : null;
            return $booking;
        });
        return response()->json(['data' => $bookings]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_no' => 'required|string|unique:bookings,booking_no',
            'city' => 'required|string',
            'booking_date' => 'required|date',
            'flight_id' => 'required|exists:flights,id',
            'departure_datetime' => 'required|date',
            'arrival_datetime' => 'required|date|after:departure_datetime',
            'class' => 'required|in:business,economy',
            'status' => 'required|in:booked,cancelled,scratched',
            'price' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'passenger_name' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
        ]);

        $booking = Booking::create($validated);
        return response()->json($booking->load(['flight.airline', 'customer']), 201);
    }

    public function show($id)
    {
        $booking = Booking::with(['flight.airline', 'flight.originCity', 'flight.destinationCity', 'customer'])->findOrFail($id);
        $flight = $booking->flight;
        $origin = $flight->originCity;
        $destination = $flight->destinationCity;
        $origin_tax = $origin ? $origin->airport_tax : 0;
        $destination_tax = $destination ? $destination->airport_tax : 0;
        $currency_code = $origin ? $origin->currency_code : 'USD';
        $flight_price = $flight ? $flight->price : 0;
        if ($booking->class === 'business') {
            $flight_price = $flight_price * 1.5;
        }
        $rate = CurrencyRate::where('currency_code', $currency_code)
            ->whereDate('rate_date', $booking->booking_date)
            ->orderByDesc('rate_date')
            ->first();
        $rate_to_usd = $rate ? $rate->rate_to_usd : 1;
        $total_price_local = $rate_to_usd > 0 ? ($origin_tax + $destination_tax + $flight_price) / $rate_to_usd : null;
        $booking->local_currency = $currency_code;
        $booking->total_price_local = $total_price_local ? round($total_price_local, 2) : null;
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $validated = $request->validate([
            'booking_no' => 'required|string|unique:bookings,booking_no,' . $id,
            'city' => 'required|string',
            'booking_date' => 'required|date',
            'flight_id' => 'required|exists:flights,id',
            'departure_datetime' => 'required|date',
            'arrival_datetime' => 'required|date|after:departure_datetime',
            'class' => 'required|in:business,economy',
            'status' => 'required|in:booked,cancelled,scratched',
            'price' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'passenger_name' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
        ]);

        $booking->update($validated);
        return response()->json($booking->load(['flight.airline', 'customer']));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
