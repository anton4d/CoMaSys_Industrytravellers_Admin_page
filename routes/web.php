<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlatformUserController;
use App\Http\Controllers\AdminController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    // all routes to do with the location backend
    Route::get('locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    
    // all routes to do with the platform user
    Route::get('/users', [PlatformUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/verify', [PlatformUserController::class, 'showVerify'])->name('users.verify.show');
    Route::post('/users/{user}/verify', [PlatformUserController::class, 'verify'])->name('users.verify');
    Route::post('/users/{user}/deny', [PlatformUserController::class, 'deny'])->name('users.deny');

    // all routes to do with admin users
    Route::get('/admin/register', [AdminController::class, 'showRegister'])->name('admin.register');
    Route::post('/admin/register', [AdminController::class, 'store'])->name('admin.store');

});

require __DIR__ . '/settings.php';
