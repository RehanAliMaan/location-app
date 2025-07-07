<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()          { return Country::all(); }

    public function store(Request $r)
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        return Country::create($data);
    }

    public function show(Country $country)  { return $country; }

    public function update(Request $r, Country $country)
    {
        $data = $r->validate(['name' => 'required|string|max:255']);
        $country->update($data);
        return $country->refresh();
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return response()->noContent();
    }
}
