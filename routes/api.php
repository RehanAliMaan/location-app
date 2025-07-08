<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CountryController,
    ProvinceController,
    CityController,
    ExternalLocationController as Ext
};

// CRUD for internal database
Route::apiResource('countries', CountryController::class);
Route::apiResource('provinces', ProvinceController::class);
Route::apiResource('cities',    CityController::class);

Route::get('countries/{country}/provinces', [ProvinceController::class, 'byCountry']);
Route::get('provinces/{province}/cities',   [CityController::class,     'byProvince']);

// EXTERNAL live endpoints using proxy controller
Route::prefix('ext')->group(function () {
    Route::get('countries', [Ext::class, 'countries']);
    Route::get('countries/{iso}/provinces', [Ext::class, 'provinces']);
    Route::get('countries/{iso}/provinces/{province}/cities', [Ext::class, 'cities']);
    Route::get('cities/{city}/areas', [Ext::class, 'areas']); // ✅ CORRECT
});


