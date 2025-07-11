<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CurrencyRateController extends Controller
{
    // GET /currency-rates
    public function index()
    {
        $rates = CurrencyRate::latest('rate_date')->get();
        return response()->json(['data' => $rates]);
    }

    // POST /currency-rates
    public function store(Request $request)
    {
        $validated = $request->validate([
            'currency_code' => 'required|string|size:3',
            'rate_to_usd' => 'required|numeric|min:0',
            'rate_date' => 'required|date',
        ]);

        $rate = CurrencyRate::create($validated);

        return response()->json($rate, 201);
    }

    public function show($id)
    {
        $rate = CurrencyRate::findOrFail($id);
        return response()->json($rate);
    }

    public function update(Request $request, $id)
    {
        $rate = CurrencyRate::findOrFail($id);
        
        $validated = $request->validate([
            'currency_code' => 'required|string|size:3',
            'rate_to_usd' => 'required|numeric|min:0',
            'rate_date' => 'required|date',
        ]);

        $rate->update($validated);
        return response()->json($rate);
    }

    public function destroy($id)
    {
        $rate = CurrencyRate::findOrFail($id);
        $rate->delete();
        return response()->json(['message' => 'Currency rate deleted successfully']);
    }
}
