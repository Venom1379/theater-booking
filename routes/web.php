<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;




use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TheaterController;
use App\Http\Controllers\Admin\ShowController;



use App\Http\Controllers\AuthController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

// Public Routes

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\Front\HomeController::class, 'register'])->name('register');
Route::post('/register/store', [\App\Http\Controllers\Front\HomeController::class, 'store'])
    ->name('register.store');


// Admin Routes (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', fn () => view('index'))->name('root');
    // Route::get('/', fn () => view('index'))->name('home');

    Route::prefix('admin')->name('admin.')->group(function () { 
        Route::resource('users', UserController::class);
        Route::resource('theaters', TheaterController::class);
        Route::resource('shows', ShowController::class);
    });
     

});