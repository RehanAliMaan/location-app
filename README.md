
# My Location App – Development Steps & Documentation

## 1. Laravel Project Setup

- Created Laravel project:

  ```bash
  laravel new my-location-app
  ```

- Configured `.env` file with database credentials.

## 2. Database Models and Migrations

- Created Models and Migrations:

  ```bash
  php artisan make:model Country -m
  php artisan make:model Province -m
  php artisan make:model City -m
  ```

- Defined relationships:
  - Country hasMany Province
  - Province belongsTo Country, hasMany City
  - City belongsTo Province

- Updated migration files with foreign keys.
- Ran migrations:

  ```bash
  php artisan migrate
  ```

## 3. API Routes and Controllers

- Created API Controllers:

  ```bash
  php artisan make:controller Api/CountryController
  php artisan make:controller Api/ProvinceController
  php artisan make:controller Api/CityController
  php artisan make:controller Api/ExternalLocationController
  ```

- Defined RESTful API routes in `routes/api.php`:

  - Internal:
    - `/api/countries`
    - `/api/provinces`
    - `/api/cities`
  - External:
    - `/api/ext/countries`
    - `/api/ext/countries/{country}/provinces`
    - `/api/ext/countries/{country}/provinces/{province}/cities`

## 4. User Screen Setup (Frontend)

- Created `resources/views/location.blade.php` for the user form.
- Added routes in `web.php`:

  ```php
  Route::view('/location', 'location');
  Route::get('/', fn () => redirect('/location'));
  ```

- Implemented dynamic dropdowns and Google Maps integration using JavaScript.

## 5. Admin Panel (CRUD Interface)

- Created Admin Controllers:

  ```bash
  php artisan make:controller Admin/CountryAdminController --resource
  php artisan make:controller Admin/ProvinceAdminController --resource
  php artisan make:controller Admin/CityAdminController --resource
  ```

- Defined admin routes in `routes/web.php`:

  ```php
  Route::prefix('admin')->name('admin.')->group(function () {
      Route::resource('countries', CountryAdminController::class);
      Route::resource('provinces', ProvinceAdminController::class);
      Route::resource('cities', CityAdminController::class);
  });
  ```

- Built Blade views for countries, provinces, and cities (index, create, edit, etc.) with form validation.

## 6. Admin Dashboard

- Created `admin/dashboard.blade.php` with links:

  - CRUD Countries
  - CRUD Provinces
  - CRUD Cities

- Linked dashboard to `/admin` route.
- Added link to the Admin Panel on the user page (`/location`).

## 7. Merging Admin Data into User Dropdowns

- Modified `ExternalLocationController` to merge data from:
  - Internal database (Country, Province, City models)
  - External APIs (RestCountries & CountriesNow)

- Updated the following endpoints to return merged, deduplicated results:

  - `/api/ext/countries`
  - `/api/ext/countries/{country}/provinces`
  - `/api/ext/countries/{country}/provinces/{province}/cities`

---

## How to Run the Project

1. Clone or unzip the project.
2. Configure `.env` with your database credentials.
3. Run the following:

   ```bash
   composer install
   php artisan migrate
   php artisan serve
   ```

4. Access the app:

   - User Page: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)
   - Admin Panel: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## Workflow Summary

| Screen        | Functionality                                                                 |
|---------------|------------------------------------------------------------------------------|
| `/location`   | User selects Country → Province → City. Uses DB + external APIs. Google Map shows city. |
| `/admin`      | Admin dashboard with navigation to Country/Province/City CRUD pages.         |
| CRUD Screens  | Full create, edit, update, delete support for countries, provinces, cities.  |
| Database      | Stores entries added via Admin and merges with external data.                |
