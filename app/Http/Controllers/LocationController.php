<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Location;
use App\Models\LocationInfo;
use Illuminate\Http\Request;
use App\Enums\LocationType;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'brand_id'     => 'required|integer|exists:discounts.brands,id',
            'type'         => 'required|integer',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'address'      => 'required|string',
            'description'  => 'nullable|string',
            'link'         => 'nullable|string',
            'photo_path'   => 'nullable|string',
            'discount_info' => 'nullable|string',
        ]);

        $location = Location::create($data);

        LocationInfo::create([
            'location_id'  => $location->id,
            'address'      => $data['address'],
            'description'  => $data['description'],
            'link'         => $data['link'] ?? null,
            'photo_path'   => $data['photo_path'] ?? null,
            'discount_info' => $data['discount_info'] ?? null,
        ]);

        return redirect()->route('locations.index')->with('success', 'Location created!');
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
            'location' => $location->load(['info', 'brand']),
            'types'    => LocationType::toArray(),
            'brands'   => Brand::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'brand_id'     => 'required|integer|exists:discounts.brands,id',
            'type'         => 'required|integer',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'address'      => 'required|string',
            'description'  => 'nullable|string',
            'link'         => 'nullable|string',
            'photo_path'   => 'nullable|string',
            'discount_info' => 'nullable|string',
        ]);

        $location->update($data);

        $location->info()->updateOrCreate(
            ['location_id' => $location->id],
            [
                'address'      => $data['address'],
                'description'  => $data['description'],
                'link'         => $data['link'] ?? null,
                'photo_path'   => $data['photo_path'] ?? null,
                'discount_info' => $data['discount_info'] ?? null,
            ]
        );

        return redirect()->route('locations.index')->with('success', 'Location updated!');
    }
}
