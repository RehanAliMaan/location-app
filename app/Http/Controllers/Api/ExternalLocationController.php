<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Province;
use Illuminate\Support\Facades\Http;

class ExternalLocationController extends Controller
{
    /* ----------------------------------------
       GET /api/ext/countries
       Combines DB countries + external list
    ---------------------------------------- */
    public function countries()
    {
        /* 1) Countries stored in your DB */
        $db = Country::pluck('name');   // e.g. ["Pakistan", "Testland"]

        /* 2) External countries list */
        $ext = collect(
            Http::timeout(10)
                ->get('https://restcountries.com/v3.1/all?fields=name')
                ->json() ?? []
        )
        ->pluck('name.common');

        /* 3) Merge, deduplicate, sort */
        $all = $db->merge($ext)->filter()->unique()->sort()->values()
               ->map(fn($name) => ['name' => $name]);

        return response()->json($all);
    }

    /* ----------------------------------------
       GET /api/ext/countries/{country}/provinces
       country = plain name (URL‑encoded)
    ---------------------------------------- */
    public function provinces(string $country)
    {
        $countryName = urldecode($country);

        /* 1) Provinces from your DB */
        $dbProvinces = Country::where('name', $countryName)
                        ->first()
                        ?->provinces
                        ->pluck('name') ?? collect();

        /* 2) External provinces */
        $ext = collect(
            Http::timeout(10)
                ->post('https://countriesnow.space/api/v0.1/countries/states', [
                    'country' => $countryName
                ])
                ->json('data.states') ?? []
        )->pluck('name');

        /* 3) Merge, deduplicate */
        $all = $dbProvinces->merge($ext)->filter()->unique()->values()
               ->map(fn($name) => ['name' => $name]);

        return response()->json($all);
    }

    /* ----------------------------------------
       GET /api/ext/countries/{country}/provinces/{state}/cities
    ---------------------------------------- */
    public function cities(string $country, string $state)
    {
        $countryName  = urldecode($country);
        $provinceName = urldecode($state);

        /* 1) Cities from your DB */
        $dbCities = Province::where('name', $provinceName)
                     ->first()
                     ?->cities
                     ->pluck('name') ?? collect();

        /* 2) External cities */
        $ext = collect(
            Http::timeout(10)
                ->post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                    'country' => $countryName,
                    'state'   => $provinceName
                ])
                ->json('data') ?? []
        );

        /* 3) Merge, deduplicate */
        $all = $dbCities->merge($ext)->filter()->unique()->values()
               ->map(fn($city) => ['name' => $city]);

        return response()->json($all);
    }
}
