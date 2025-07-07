markdown

Copy
# Step-by-Step Development Process

## Laravel Project Setup
1. **Created Laravel project:**
   ```bash
   laravel new my-location-app
Set up .env with proper DB credentials.
Database Models and Migrations
Created models with relationships:

Country hasMany Province
Province belongsTo Country, hasMany City
City belongsTo Province
bash

Copy
php artisan make:model Country -m
php artisan make:model Province -m
php artisan make:model City -m
Updated migrations with appropriate fields and foreign keys.

Ran migrations:

bash

Copy
php artisan migrate
API Routes and Controllers
Created API controllers:

bash

Copy
php artisan make:controller Api/CountryController
php artisan make:controller Api/ProvinceController
php artisan make:controller Api/CityController
php artisan make:controller Api/ExternalLocationController
Set up RESTful API routes in routes/api.php:

Internal:
/api/countries
/api/provinces
/api/cities
External:
/api/ext/countries
/api/ext/countries/{country}/provinces
/api/ext/countries/{country}/provinces/{province}/cities
User Screen Setup (Frontend)
Created /resources/views/location.blade.php for user form.

Created a controller method to return the location view.

Added route in web.php:

php

Copy
Route::view('/location', 'location');
Route::get('/', fn () => redirect('/location'));
Implemented frontend JS:

Fetch dropdown data dynamically via external APIs.
Show a Google Map using the selected city.
Admin Panel (CRUD Interface)
Created controllers:

bash

Copy
php artisan make:controller Admin/CountryAdminController --resource
php artisan make:controller Admin/ProvinceAdminController --resource
php artisan make:controller Admin/CityAdminController --resource
Defined admin routes in routes/web.php:

php

Copy
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('countries', CountryAdminController::class);
    Route::resource('provinces', ProvinceAdminController::class);
    Route::resource('cities', CityAdminController::class);
});
Created Blade views for each resource:

Views: index, create, edit
Included form validation and CRUD logic.
Admin Dashboard
Created admin/dashboard.blade.php showing:

Buttons to: CRUD Countries, CRUD Provinces, CRUD Cities
Linked to /admin route and added a dashboard controller method.

Added a link to the admin panel on the user screen.

Merging Admin Data into Location Dropdowns
Modified ExternalLocationController:
Combined results from:
Your DB (via Country, Province, City models)
External APIs (RestCountries & CountriesNow)
Merged and deduplicated results in:
/api/ext/countries
/api/ext/countries/{country}/provinces
/api/ext/countries/{country}/provinces/{province}/cities
How to Run the Project
Clone or unzip the project folder.

Configure .env with your DB settings.

Run:

bash

Copy
composer install
php artisan migrate
Go to your project folder and type:

bash

Copy
php artisan serve
Open the app:

User Page: http://127.0.0.1:8000/
Admin Dashboard: http://127.0.0.1:8000/admin
Workflow Summary
/location: User selects Country → Province → City, using both DB and external data. City location is shown on Google Map.
/admin: Admin dashboard to manage Countries, Provinces, and Cities.
CRUD screens for each section (Country, Province, City) support create, edit, delete via web forms.
Database: Stores countries/provinces/cities added via admin and merges them with external data.
