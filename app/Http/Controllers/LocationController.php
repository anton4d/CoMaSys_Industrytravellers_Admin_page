<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\City;
use App\Models\Location;
use App\Models\LocationInfo;
use Illuminate\Http\Request;
use App\Enums\LocationType;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'brand_id'      => 'required|integer|exists:discounts.brands,id',
            'type'          => 'required|integer',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            'address'       => 'required|string',
            'description'   => 'nullable|string',
            'link'          => 'nullable|string',
            'photo_path'    => 'nullable|string',
            'discount_info' => 'nullable|string',
            'city_name'     => 'required|string',
            'city_latitude'  => 'nullable|numeric',
            'city_longitude' => 'nullable|numeric',
        ]);

        $city = City::where('name', $data['city_name'])->first();

        if (!$city && empty($data['city_latitude'])) {
            return back()->with('city_not_found', $data['city_name']);
        }

        if (!$city) {
            $city = City::create([
                'name'      => $data['city_name'],
                'latitude'  => $data['city_latitude'],
                'longitude' => $data['city_longitude'],
            ]);
        }

        $location = Location::create([
            'name'      => $data['name'],
            'brand_id'  => $data['brand_id'],
            'type'      => $data['type'],
            'latitude'  => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        LocationInfo::create([
            'location_id'   => $location->id,
            'city_id'       => $city->id,
            'address'       => $data['address'],
            'description'   => $data['description'] ?? null,
            'link'          => $data['link'] ?? null,
            'photo_path'    => $data['photo_path'] ?? null,
            'discount_info' => $data['discount_info'] ?? null,
        ]);

        return redirect()->route('locations.create')->with('success', 'Location created!');
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'brand_id'      => 'required|integer|exists:discounts.brands,id',
            'type'          => 'required|integer',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            'address'       => 'required|string',
            'description'   => 'nullable|string',
            'link'          => 'nullable|string',
            'photo_path'    => 'nullable|string',
            'discount_info' => 'nullable|string',
            'city_name'     => 'required|string',
            'city_latitude'  => 'nullable|numeric',
            'city_longitude' => 'nullable|numeric',
        ]);

        $city = City::where('name', $data['city_name'])->first();

        if (!$city && empty($data['city_latitude'])) {
            return back()->with('city_not_found', $data['city_name']);
        }

        if (!$city) {
            $city = City::create([
                'name'      => $data['city_name'],
                'latitude'  => $data['city_latitude'],
                'longitude' => $data['city_longitude'],
            ]);
        }

        $location->update([
            'name'      => $data['name'],
            'brand_id'  => $data['brand_id'],
            'type'      => $data['type'],
            'latitude'  => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        $location->info()->updateOrCreate(
            ['location_id' => $location->id],
            [
                'city_id'       => $city->id,
                'address'       => $data['address'],
                'description'   => $data['description'] ?? null,
                'link'          => $data['link'] ?? null,
                'photo_path'    => $data['photo_path'] ?? null,
                'discount_info' => $data['discount_info'] ?? null,
            ]
        );

        return redirect()->route('locations.index')->with('success', 'Location updated!');
    }

    public function create()
    {
        return inertia('Locations/Create', [
            'types'  => LocationType::toArray(),
            'brands' => Brand::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function index()
    {
        $locations = Location::with(['info', 'brand'])
            ->get()
            ->sortBy(fn($location) => $location->info?->address ?? '')
            ->groupBy(fn($location) => $location->brand?->name ?? 'Unknown Brand');

        return inertia('Locations/Index', [
            'locations' => $locations,
            'types'     => LocationType::toArray(),
        ]);
    }

    public function destroy(Location $location)
    {
        $location->info()->delete();
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted!');
    }

    public function edit(Location $location)
    {
        return inertia('Locations/Edit', [
            'location' => $location->load(['info', 'brand', 'info.city']),
            'types'    => LocationType::toArray(),
            'brands'   => Brand::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function syncLocations()
    {
        $response = Http::withHeaders([
            'X-Admin-Key' => config('services.backend_api.key'),
            'Origin' => config('app.url'),
        ])->post(config('services.backend_api.url') . '/admin/sync-locations');
        if ($response->successful()) {
            return back()->with('success', 'Locations synced successfully!');
        }

        return back()->withErrors(['sync' => 'Sync failed: ' . $response->json('error', 'Unknown error')]);
    }
}
