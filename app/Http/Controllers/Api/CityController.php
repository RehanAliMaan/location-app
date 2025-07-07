<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()          { return City::with('province.country')->get(); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'        => 'required',
            'province_id' => 'required|exists:provinces,id',
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
        ]);
        return City::create($data);
    }

    public function show(City $city)  { return $city->load('province.country'); }

    public function update(Request $r, City $city)
    {
        $data = $r->validate([
            'name'        => 'required',
            'province_id' => 'required|exists:provinces,id',
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
        ]);
        $city->update($data);
        return $city->refresh();
    }

    public function destroy(City $city)
    {
        $city->delete();
        return response()->noContent();
    }

    // helper for cascade
    public function byProvince(int $province_id)
    {
        return City::where('province_id', $province_id)->get(['id','name','lat','lng']);
    }
}
