<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CountryController,
    ProvinceController,
    CityController,
    ExternalLocationController as Ext  // <— new proxy controller
};

/* --------------------------------------------------------------
 |  INTERNAL CRUD + helper endpoints (your own database tables)
 * --------------------------------------------------------------
*/
Route::apiResource('countries', CountryController::class);
Route::apiResource('provinces', ProvinceController::class);
Route::apiResource('cities',    CityController::class);

Route::get('countries/{country}/provinces', [ProvinceController::class, 'byCountry']);
Route::get('provinces/{province}/cities',   [CityController::class,     'byProvince']);

/* --------------------------------------------------------------
 |  EXTERNAL “LIVE” ENDPOINTS  (no DB, proxy to public APIs)
 *   /api/ext/countries                   → all countries
 *   /api/ext/countries/{ISO}/provinces   → states in that country
 *   /api/ext/countries/{ISO}/provinces/{ProvinceName}/cities → cities
 * --------------------------------------------------------------
*/
Route::prefix('ext')->group(function () {
    Route::get('countries', [Ext::class, 'countries']);

    Route::get(
        'countries/{iso}/provinces',
        [Ext::class, 'provinces']
    );

    Route::get(
        'countries/{iso}/provinces/{province}/cities',
        [Ext::class, 'cities']
    );
});
