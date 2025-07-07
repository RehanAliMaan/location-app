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
        ]);

        City::create($request->all());

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
        ]);

        $city->update($request->all());

        return redirect()->route('admin.cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'City deleted.');
    }
}
