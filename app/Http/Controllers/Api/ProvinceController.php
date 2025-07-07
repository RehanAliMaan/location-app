<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()          { return Province::with('country')->get(); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'       => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);
        return Province::create($data);
    }

    public function show(Province $province)  { return $province->load('country'); }

    public function update(Request $r, Province $province)
    {
        $data = $r->validate([
            'name'       => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);
        $province->update($data);
        return $province->refresh();
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return response()->noContent();
    }

    // helper for cascade
    public function byCountry(int $country_id)
    {
        return Province::where('country_id', $country_id)->get(['id', 'name']);
    }
}
