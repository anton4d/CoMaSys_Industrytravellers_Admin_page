<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Enums\UserType;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::with('brand')
            ->orderBy('expiration_date')
            ->get()
            ->groupBy(fn($discount) => $discount->brand?->name ?? 'Unknown Brand');

        return inertia('Discounts/Index', [
            'discounts' => $discounts,
            'user_types' => UserType::toArray(),
        ]);
    }

    public function create()
    {
        return inertia('Discounts/Create', [
            'brands'     => Brand::orderBy('name')->get(['id', 'name']),
            'user_types' => UserType::toArray(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_id'        => 'required|integer|exists:discounts.brands,id',
            'title'           => 'required|string',
            'description'     => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'user_type'       => 'required|integer',
        ]);

        Discount::create($data);

        return redirect()->route('discount.index')->with('success', 'Discount created!');
    }

    public function edit(Discount $discount)
    {
        return inertia('Discounts/Edit', [
            'discount'   => $discount->load('brand'),
            'brands'     => Brand::orderBy('name')->get(['id', 'name']),
            'user_types' => UserType::toArray(),
        ]);
    }

    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'brand_id'        => 'required|integer|exists:discounts.brands,id',
            'title'           => 'required|string',
            'description'     => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'user_type'       => 'required|integer',
        ]);

        $discount->update($data);

        return redirect()->route('discount.index')->with('success', 'Discount updated!');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discount.index')->with('success', 'Discount deleted!');
    }
}