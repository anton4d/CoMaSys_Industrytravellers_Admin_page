<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount(['locations', 'discounts'])->orderBy('name')->get();

        return inertia('Brands/Index', [
            'brands' => $brands,
        ]);
    }

    public function create()
    {
        return inertia('Brands/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|unique:discounts.brands,name',
            'logo_url'  => 'nullable|string',
            'website'   => 'nullable|string',
        ]);

        Brand::create($data);

        return redirect()->route('brand.create')->with('success', 'Brand created!');
    }

    public function edit(Brand $brand)
    {
        return inertia('Brands/Edit', [
            'brand' => $brand,
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name'     => 'required|string|unique:discounts.brands,name,' . $brand->id,
            'logo_url' => 'nullable|string',
            'website'  => 'nullable|string',
        ]);

        $brand->update($data);

        return redirect()->route('brand.index')->with('success', 'Brand updated!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand deleted!');
    }

    public function show(Brand $brand)
    {
        return inertia('Brands/Show', [
            'brand'     => $brand->load(['discounts']),
            'locations' => $brand->locations()->with('info')->get(),
        ]);
    }
}