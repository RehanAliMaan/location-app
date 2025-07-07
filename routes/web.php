<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Admin\CountryAdminController;
use App\Http\Controllers\Admin\ProvinceAdminController;
use App\Http\Controllers\Admin\CityAdminController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('countries', CountryAdminController::class);
    Route::resource('provinces', ProvinceAdminController::class);
    Route::resource('cities', CityAdminController::class);
});


//Route::get('/location', function () {
//   return view('location');
//});

// --- USER SCREEN ----------
Route::view('/', 'location');   // root now shows the location picker
// (Optional) keep a second alias if you still want /location to work:
Route::view('/location', 'location');
