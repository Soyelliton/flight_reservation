<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FlightAvailability;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $flights = Flight::with('airline')->get();
        return response()->json(['data' => $flights]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|unique:flights,flight_number',
            'airline_id' => 'required|exists:airlines,id',
            'business_class' => 'required|boolean',
            'smoking_allowed' => 'required|boolean',
        ]);

        $flight = Flight::create($validated);
        return response()->json($flight->load('airline'), 201);
    }

    public function show($id)
    {
        $flight = Flight::with('airline')->findOrFail($id);
        return response()->json($flight);
    }

    public function update(Request $request, $id)
    {
        $flight = Flight::findOrFail($id);
        
        $validated = $request->validate([
            'flight_number' => 'required|string|unique:flights,flight_number,' . $id,
            'airline_id' => 'required|exists:airlines,id',
            'business_class' => 'required|boolean',
            'smoking_allowed' => 'required|boolean',
        ]);

        $flight->update($validated);
        return response()->json($flight->load('airline'));
    }

    public function destroy($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();
        return response()->json(['message' => 'Flight deleted successfully']);
    }

    public function availability($id)
    {
        return FlightAvailability::where('flight_id', $id)->get();
    }
}
