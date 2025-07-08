<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class CityAdminController extends Controller
{
    public function index()
    {
        $cities = City::with('province.country')->get();
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        $provinces = Province::with('country')->get();
        return view('admin.cities.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'province_id' => 'required|exists:provinces,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        City::create([
            'name' => $request->name,
            'province_id' => $request->province_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('admin.cities.index')->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
        $provinces = Province::with('country')->get();
        return view('admin.cities.edit', compact('city', 'provinces'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required',
            'province_id' => 'required|exists:provinces,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $city->update([
            'name' => $request->name,
            'province_id' => $request->province_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('admin.cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'City deleted.');
    }
}
