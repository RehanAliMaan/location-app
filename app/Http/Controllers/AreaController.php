<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{
    public function getAreas(Request $request)
    {
        $city = $request->query('city');
        $username = 'astafa'; // 🔁 Replace with your GeoNames username

        if (!$city) {
            return response()->json(['error' => 'City name is required.'], 400);
        }

        $response = Http::get("http://api.geonames.org/searchJSON", [
            'q' => $city,
            'featureClass' => 'P',
            'maxRows' => 30,
            'username' => $username
        ]);

        $data = $response->json();

        if (isset($data['geonames'])) {
            $areas = collect($data['geonames'])->map(function ($item) {
                return [
                    'name' => $item['name'],
                    'lat' => $item['lat'],
                    'lon' => $item['lng']
                ];
            });
            return response()->json($areas);
        }

        return response()->json(['error' => 'No areas found'], 404);
    }
}

