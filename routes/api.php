<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


use App\Models\City;
use App\Models\Category;


// Route::get('/cities', function () {
//     return response()->json(City::all());
// });

// Route::get('/categories', function () {
//     return response()->json(Category::all());
// });

use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CityController;



Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}/subcategories', [CategoryController::class, 'getSubcategories']);

Route::get('countries', [CityController::class, 'getCountries']);
Route::get('countries/{id}/states', [CityController::class, 'getStates']);
Route::get('states/{id}/cities', [CityController::class, 'getCities']);

Route::get('cities', [CityController::class, 'index']);
Route::get('businesses', [BusinessController::class, 'index']);
Route::get('businesses/category/{category_id}', [BusinessController::class, 'getByCategory']);
Route::get('businesses/cities/{city_id}', [BusinessController::class, 'getByCity']);
Route::get('businesses/getCityBySlug/{slug}', [BusinessController::class, 'getCityBySlug']);

Route::get('businesses/{id}', [BusinessController::class, 'show']);


Route::get('user-businesses/{user_id}', [BusinessController::class, 'getUserBusinesses']);

// oute::get('/businesses/city/{slug}', [BusinessController::class, 'getBusinessesByCity']);
// Route::get('/businesses/{id}', [BusinessController::class, 'show']);


use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/businesses', [BusinessController::class, 'store']);
    
});
Route::post('add-business', [BusinessController::class, 'store']);

