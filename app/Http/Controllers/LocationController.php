<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Enums\LocationType;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'type'          => 'required|integer',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            'expiration_date' => 'required|date',
            'address'       => 'required|string',
            'description'   => 'nullable|string',
            'link'          => 'nullable|string',
            'photo_path'    => 'nullable|string',
            'discount_info' => 'nullable|string',
        ]);


        $location = Location::create($data);

        LocationInfo::create([
            'location_id'   => $location->id,
            'address'       => $data['address'],
            'description'   => $data['description'],
            'link'          => $data['link'] ?? null,
            'photo_path'    => $data['photo_path'] ?? null,
            'discount_info' => $data['discount_info'] ?? null,
        ]);

        return redirect()->route('locations.index')->with('success', 'Location created!');
    }

    public function create()
    {
        return inertia('Locations/Create', [
            'types' => LocationType::toArray(),
        ]);
    }

    public function index()
    {
        $locations = Location::with('info')->get()
            ->groupBy(function ($location) {
                $parts = explode(', ', $location->info?->address ?? '');
                $count = count($parts);
                $city    = $parts[$count - 3] ?? 'Unknown';
                $country = $parts[$count - 1] ?? 'Unknown';
                return "$city, $country";
            });

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
            'location' => $location->load('info'),
            'types'    => LocationType::toArray(),
        ]);
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name'            => 'required|string',
            'type'            => 'required|integer',
            'latitude'        => 'required|numeric',
            'longitude'       => 'required|numeric',
            'expiration_date' => 'required|date',
            'address'         => 'required|string',
            'description'     => 'nullable|string',
            'link'            => 'nullable|string',
            'photo_path'      => 'nullable|string',
            'discount_info'   => 'nullable|string',
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
