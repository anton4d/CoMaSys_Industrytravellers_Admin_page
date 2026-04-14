<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function check(Request $request)
    {
        $city = City::where('name', $request->query('name'))->first();
        return response()->json([
            'exists'    => (bool)$city,
            'latitude'  => $city?->latitude,
            'longitude' => $city?->longitude,
        ]);
    }
}
