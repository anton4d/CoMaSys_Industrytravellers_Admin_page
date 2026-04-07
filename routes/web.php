<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlatformUserController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('locations/create', 'Locations/Create')->name('locations.create');
    Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    
    Route::get('/users', [PlatformUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/verify', [PlatformUserController::class, 'showVerify'])->name('users.verify.show');
    Route::post('/users/{user}/verify', [PlatformUserController::class, 'verify'])->name('users.verify');
    Route::post('/users/{user}/deny', [PlatformUserController::class, 'deny'])->name('users.deny');
});

require __DIR__ . '/settings.php';
