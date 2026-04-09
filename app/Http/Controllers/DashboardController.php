<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Discount;
use App\Models\PlatformUser;

class DashboardController extends Controller
{
    public function index()
    {
        return inertia('Dashboard', [
            'recentLocations' => Location::with('info')
                ->latest()
                ->take(5)
                ->get(),

            'expiringDiscounts' => Discount::with('brand')
                ->where('expiration_date', '>=', now())
                ->orderBy('expiration_date')
                ->take(3)
                ->get(),
        ]);
    }
}