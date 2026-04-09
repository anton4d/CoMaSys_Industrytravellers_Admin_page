<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Location;
use App\Models\LocationInfo;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\AdminPermission;

class CsvImportController extends Controller
{
    public function index(Request $request)
    {
        return inertia('CsvImport/Index', [
            'model' => $request->query('model'),
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file'  => 'required|file|mimes:csv,txt',
            'model' => 'required|string|in:locations,brands,discounts',
        ]);

        $user = $request->user();
        $allowed = match ($request->model) {
            'locations' => $user->is_super_admin || $user->{AdminPermission::ManageLocations->value},
            'brands'    => $user->is_super_admin || $user->{AdminPermission::ManageBrands->value},
            'discounts' => $user->is_super_admin || $user->{AdminPermission::ManageDiscounts->value},
        };

        if (!$allowed) {
            abort(403, 'You do not have permission to import ' . $request->model . '.');
        }

        $path = $request->file('file')->getRealPath();
        $rows = array_map(fn($line) => str_getcsv($line, ',', '"', ''), file($path));
        $headers = array_map('trim', array_shift($rows));

        try {
            DB::connection('discounts')->beginTransaction();

            match ($request->model) {
                'locations' => $this->importLocations($headers, $rows),
                'brands'    => $this->importBrands($headers, $rows),
                'discounts' => $this->importDiscounts($headers, $rows),
            };

            DB::connection('discounts')->commit();
        } catch (\Exception $e) {
            DB::connection('discounts')->rollBack();
            return back()->withErrors(['file' => 'Import failed: ' . $e->getMessage()]);
        }

        return back()->with('success', 'CSV imported successfully!');
    }

    private function importBrands(array $headers, array $rows): void
    {
        foreach ($rows as $row) {
            if (count($row) !== count($headers)) continue;
            $data = array_combine($headers, $row);

            Brand::updateOrCreate(
                ['name' => $data['name']],
                [
                    'logo_url' => $data['logo_url'] ?? null,
                    'website'  => $data['website'] ?? null,
                ]
            );
        }
    }

    private function importLocations(array $headers, array $rows): void
    {
        foreach ($rows as $row) {
            if (count($row) !== count($headers)) continue;
            $data = array_combine($headers, $row);

            $brand = Brand::where('name', $data['brand'])->firstOrFail();

            $location = Location::updateOrCreate(
                ['name' => $data['name'], 'brand_id' => $brand->id],
                [
                    'brand_id'  => $brand->id,
                    'latitude'  => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'type'      => $data['type'],
                ]
            );

            LocationInfo::updateOrCreate(
                ['location_id' => $location->id],
                [
                    'address'      => $data['address'],
                    'description'  => $data['description'] ?? null,
                    'link'         => $data['link'] ?? null,
                    'photo_path'   => $data['photo_path'] ?? null,
                    'discount_info' => $data['discount_info'] ?? null,
                ]
            );
        }
    }

    private function importDiscounts(array $headers, array $rows): void
    {
        foreach ($rows as $row) {
            if (count($row) !== count($headers)) continue;
            $data = array_combine($headers, $row);

            $brand = Brand::where('name', $data['brand'])->firstOrFail();

            Discount::updateOrCreate(
                ['title' => $data['title'], 'brand_id' => $brand->id],
                [
                    'brand_id'        => $brand->id,
                    'description'     => $data['description'] ?? null,
                    'expiration_date' => !empty($data['expiration_date']) ? $data['expiration_date'] : null,
                    'user_type'       => $data['user_type'] ?? 0,
                ]
            );
        }
    }

    public function locations()
    {
        return inertia('Locations/CsvImport');
    }
    public function brands()
    {
        return inertia('Brands/CsvImport');
    }
    public function discounts()
    {
        return inertia('Discounts/CsvImport');
    }
}
