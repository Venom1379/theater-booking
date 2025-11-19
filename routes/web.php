<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;




use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TheaterController;
use App\Http\Controllers\Admin\ShowController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Front\BookingController;


use App\Http\Controllers\Front\HomeController;




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

Route::get('/register', [HomeController::class, 'register'])->name('register');

Route::post('/register/store', [HomeController::class, 'store'])->name('register.store');


Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');

Route::get('/booking/get-data', [BookingController::class, 'getData'])->name('booking.getData');

Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');



Route::get('/', [HomeController::class, 'index'])->name('home');


// Admin Routes (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    
   
    // Route::get('/', fn () => view('index'))->name('home');

    Route::prefix('admin')->name('admin.')->group(function () { 
        Route::resource('users', UserController::class);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('theaters', TheaterController::class);
        Route::resource('shows', ShowController::class);
        // Route::resource('slots', SlotController::class);
        Route::get('slots', [SlotController::class, 'index'])->name('slots.index');
Route::post('slots/save', [SlotController::class, 'saveAll'])->name('slots.saveAll');
// optional single delete if you still want:
Route::delete('slots/{id}', [SlotController::class, 'destroy'])->name('slots.destroy');

    });
     

});