<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlatformUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\DashboardController;
Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // all routes to do with the location backend
    Route::get('locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    Route::get('/locations/csv-import', [CsvImportController::class, 'locations'])->name('csv.locations');

    // all routes to do with the platform user
    Route::get('users', [PlatformUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/verify', [PlatformUserController::class, 'showVerify'])->name('users.verify.show');
    Route::post('users/{user}/verify', [PlatformUserController::class, 'verify'])->name('users.verify');
    Route::post('users/{user}/deny', [PlatformUserController::class, 'deny'])->name('users.deny');

    // all routes to do with admin users
    Route::get('admins/register', [AdminController::class, 'showRegister'])->name('admin.register');
    Route::post('admins/register', [AdminController::class, 'store'])->name('admin.store');
    Route::get('admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('admins/{admin}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('admins', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('admins/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // all routes to do with brand
    Route::get('brands/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('brands/create', [BrandController::class, 'store'])->name('brand.store');
    Route::get('brands/show/{brand}', [BrandController::class, 'show'])->name('brand.show');
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brand.update');
    Route::get('brands', [BrandController::class, 'index'])->name('brand.index');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');
    Route::get('/brands/csv-import',    [CsvImportController::class, 'brands'])->name('csv.brands');

    // all routes to do with discounts
    Route::get('discounts/create', [DiscountController::class, 'create'])->name('discount.create');
    Route::post('discounts/create', [DiscountController::class, 'store'])->name('discount.store');
    Route::get('discounts/{discount}/edit', [DiscountController::class, 'edit'])->name('discount.edit');
    Route::put('discounts/{discount}', [DiscountController::class, 'update'])->name('discount.update');
    Route::get('discounts', [DiscountController::class, 'index'])->name('discount.index');
    Route::delete('discounts/{discount}', [DiscountController::class, 'destroy'])->name('discount.destroy');
    Route::get('/discounts/csv-import', [CsvImportController::class, 'discounts'])->name('csv.discounts');

    // all routes to do with csv controller
    Route::get('/csv-import', [CsvImportController::class, 'index'])->name('csv.index');
    Route::post('/csv-import', [CsvImportController::class, 'import'])->name('csv.import');

});

require __DIR__ . '/settings.php';
