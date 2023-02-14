<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('config-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    dd("Cache is cleared");
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function () {
        return redirect()->route('admin-login');
    });

    // Auth Routes
    Route::get('/login', [AuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('doLogin');

    // If Auth Login
    Route::group(['middleware' => 'auth'], function ()
    {
        // Admin Dashboard
        Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');

        // Logout
        Route::post('/logout', [AuthController::class,'logout'])->name('logout');

        // Clients
        Route::get('/clients',[UserController::class,'index'])->name('clients');
        Route::get('/new-clients',[UserController::class,'insert'])->name('clients.add');
        Route::post('/store-clients',[UserController::class,'store'])->name('clients.store');
        Route::get('/delete-clients/{id}',[UserController::class,'destroy'])->name('clients.destroy');
        Route::get('/edit-clients/{id}',[UserController::class,'edit'])->name('clients.edit');
        Route::post('/update-clients',[UserController::class,'update'])->name('clients.update');
    });

});
