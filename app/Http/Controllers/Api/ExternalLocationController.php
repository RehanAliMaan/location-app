<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ExternalLocationController extends Controller
{
    /**
     * GET /api/ext/countries
     * Returns: [ { "name": "Afghanistan" }, { "name": "Albania" }, ... ]
     */
    public function countries()
{
    $response = Http::timeout(10)
        ->get('https://restcountries.com/v3.1/all?fields=name');

    if (! $response->successful()) {
        return response()->json(['error' => 'Unable to fetch countries'], 500);
    }

    $countries = collect($response->json())
        ->pluck('name.common')
        ->filter()
        ->sort()
        ->map(fn ($name) => ['name' => $name])
        ->values();

    return response()->json($countries);
}


    /**
     * GET /api/ext/countries/{country}/provinces
     * {country} = plain country name (URL‑encoded when necessary)
     * Returns: [ { "name": "Punjab" }, { "name": "Sindh" }, ... ]
     */
    public function provinces($country)
{
    $res = Http::timeout(10)
        ->post('https://countriesnow.space/api/v0.1/countries/states', [
            'country' => urldecode($country),
        ])
        ->throw()
        ->json();

    return collect($res['data']['states'] ?? [])
        ->pluck('name')
        ->filter()
        ->map(fn($name) => ['name' => $name])
        ->values();
}


    /**
     * GET /api/ext/countries/{country}/provinces/{state}/cities
     * {country} and {state} are plain names (URL‑encoded in the route)
     * Returns: [ { "name": "Lahore" }, { "name": "Multan" } ]
     */
   public function cities($country, $state)
{
    $res = Http::timeout(10)
        ->post('https://countriesnow.space/api/v0.1/countries/state/cities', [
            'country' => urldecode($country),
            'state'   => urldecode($state),
        ])
        ->throw()
        ->json();

    return collect($res['data'] ?? [])
        ->filter()
        ->map(fn($city) => ['name' => $city])
        ->values();
}

}
