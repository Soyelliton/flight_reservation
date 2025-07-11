<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    // GET /cities
    public function index()
    {
        $cities = City::all();
        return response()->json(['data' => $cities]);
    }

    // POST /cities
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
            'state_province' => 'required|string',
        ]);

        $city = City::create($validated);
        return response()->json($city, 201);
    }

    // GET /cities/{id}
    public function show($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    // PUT /cities/{id}
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
            'state_province' => 'required|string',
        ]);

        $city->update($validated);
        return response()->json($city);
    }

    // DELETE /cities/{id}
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(['message' => 'City deleted successfully']);
    }
}
