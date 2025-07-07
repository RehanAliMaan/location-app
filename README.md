<<<<<<< HEAD
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
=======

# 📍 My Location App - Laravel Project Documentation

A Laravel-based web application with:
- 🌍 A **user page** to select Country → Province → City using both **external APIs** and **your own database**
- 🛠️ An **admin dashboard** to perform **CRUD operations** on Countries, Provinces, and Cities
- 🗺️ Integration with **Google Maps** to display the selected location

---

## ✅ Step-by-Step Development Process

### 1. 🚀 Laravel Project Setup

- Created Laravel project:
  ```bash
  laravel new my-location-app
  ```
- Configured `.env` file with correct database settings.
>>>>>>> c5eb044 (added)

---

<<<<<<< HEAD
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
=======
### 2. 🧱 Database Models and Migrations

- Created models with relationships:
  - `Country` → hasMany `Province`
  - `Province` → belongsTo `Country`, hasMany `City`
  - `City` → belongsTo `Province`

- Commands:
  ```bash
  php artisan make:model Country -m
  php artisan make:model Province -m
  php artisan make:model City -m
  ```

- Added foreign keys and ran migrations:
  ```bash
  php artisan migrate
  ```

---
>>>>>>> c5eb044 (added)

### 3. 🔗 API Routes and Controllers

- Created API controllers:
  ```bash
  php artisan make:controller Api/CountryController
  php artisan make:controller Api/ProvinceController
  php artisan make:controller Api/CityController
  php artisan make:controller Api/ExternalLocationController
  ```

<<<<<<< HEAD
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
=======
- Set up RESTful routes in `routes/api.php`:

  - Internal API:
    - `GET /api/countries`
    - `GET /api/provinces`
    - `GET /api/cities`
  
  - External API:
    - `GET /api/ext/countries`
    - `GET /api/ext/countries/{country}/provinces`
    - `GET /api/ext/countries/{country}/provinces/{province}/cities`

---

### 4. 🌐 User Screen Setup (Frontend)

- Created view:  
  `/resources/views/location.blade.php`

- Controller method to show location form.

- Routes in `routes/web.php`:
  ```php
  Route::view('/location', 'location');
  Route::get('/', fn () => redirect('/location'));
  ```
>>>>>>> c5eb044 (added)

- JavaScript fetches countries, provinces, and cities dynamically from the APIs.
- Google Maps shows the location based on selected city.

<<<<<<< HEAD
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
=======
---

### 5. 🛠️ Admin Panel (CRUD Interface)

- Created admin resource controllers:
  ```bash
  php artisan make:controller Admin/CountryAdminController --resource
  php artisan make:controller Admin/ProvinceAdminController --resource
  php artisan make:controller Admin/CityAdminController --resource
  ```

- Admin routes in `routes/web.php`:
  ```php
  Route::prefix('admin')->name('admin.')->group(function () {
      Route::resource('countries', CountryAdminController::class);
      Route::resource('provinces', ProvinceAdminController::class);
      Route::resource('cities', CityAdminController::class);
  });
  ```

- Created Blade views for:
  - `index`
  - `create`
  - `edit`

Each with forms and validation for full CRUD functionality.

---

### 6. 🧭 Admin Dashboard

- Created: `admin/dashboard.blade.php`
- Displays buttons:
  - **CRUD Countries**
  - **CRUD Provinces**
  - **CRUD Cities**
>>>>>>> c5eb044 (added)

- `/admin` route leads to the dashboard.
- Linked from the user screen (e.g. via “Admin Panel” button).

---

<<<<<<< HEAD
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
=======
### 7. 🔁 Merging Admin Data with External APIs

- Updated `ExternalLocationController`:
  - Pulls and merges country/province/city data from:
    - Your database
    - External APIs (`restcountries.com`, `countriesnow.space`)

- Deduplicates and returns merged results for:
  - `/api/ext/countries`
  - `/api/ext/countries/{country}/provinces`
  - `/api/ext/countries/{country}/provinces/{province}/cities`

---

## ▶️ How to Run the Project

1. Clone or unzip the project folder.
2. Set up `.env` with your database credentials.
3. Install dependencies:
   ```bash
   composer install
   ```
4. Run database migrations:
   ```bash
   php artisan migrate
   ```
5. Start the development server:
   ```bash
   php artisan serve
   ```

---

## 🌐 Application Workflow Summary

| URL | Functionality |
|-----|---------------|
| `/` or `/location` | User screen with country → province → city dropdowns. Uses merged data from DB and external APIs. Displays location on Google Map. |
| `/admin` | Admin dashboard with links to manage countries, provinces, and cities. |
| `/admin/countries` | CRUD Countries screen |
| `/admin/provinces` | CRUD Provinces screen |
| `/admin/cities` | CRUD Cities screen |
| `Database` | Stores values added via admin panel, and these are shown in the user dropdowns. |
>>>>>>> c5eb044 (added)
