<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    // GET /airlines
    public function index()
    {
        $airlines = Airline::all();
        return response()->json(['data' => $airlines]);
    }

    // POST /airlines
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:airlines,code',
            'name' => 'required|string',
            'country' => 'required|string',
        ]);

        $airline = Airline::create($validated);
        return response()->json($airline, 201);
    }

    // GET /airlines/{id}
    public function show($id)
    {
        $airline = Airline::findOrFail($id);
        return response()->json($airline);
    }

    // PUT /airlines/{id}
    public function update(Request $request, $id)
    {
        $airline = Airline::findOrFail($id);
        
        $validated = $request->validate([
            'code' => 'required|string|unique:airlines,code,' . $id,
            'name' => 'required|string',
            'country' => 'required|string',
        ]);

        $airline->update($validated);
        return response()->json($airline);
    }

    // DELETE /airlines/{id}
    public function destroy($id)
    {
        $airline = Airline::findOrFail($id);
        $airline->delete();
        return response()->json(['message' => 'Airline deleted successfully']);
    }
}
