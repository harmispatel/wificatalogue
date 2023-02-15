<?php

use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersSubscriptionsController;
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


// Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('doLogin');
// Logout
Route::post('/logout', [AuthController::class,'logout'])->name('logout');


Route::group(['prefix' => 'admin'], function ()
{
    // If Auth Login
    Route::group(['middleware' => 'auth'], function ()
    {
        // Admin Dashboard
        Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');

        // Clients
        Route::get('/clients',[UserController::class,'index'])->name('clients');
        Route::get('/list-clients/{id?}',[UserController::class,'clientsList'])->name('clients.list');
        Route::get('/new-clients',[UserController::class,'insert'])->name('clients.add');
        Route::post('/store-clients',[UserController::class,'store'])->name('clients.store');
        Route::post('/status-clients',[UserController::class,'changeStatus'])->name('clients.status');
        Route::post('/status-fav-clients',[UserController::class,'addToFavClients'])->name('clients.addtofav');
        Route::get('/delete-clients/{id}',[UserController::class,'destroy'])->name('clients.destroy');
        Route::get('/edit-clients/{id}',[UserController::class,'edit'])->name('clients.edit');
        Route::post('/update-clients',[UserController::class,'update'])->name('clients.update');

        // Subscription
        Route::get('/subscriptions',[SubscriptionsController::class,'index'])->name('subscriptions');
        Route::get('/new-subscription',[SubscriptionsController::class,'insert'])->name('subscriptions.add');
        Route::post('/store-subscription',[SubscriptionsController::class,'store'])->name('subscriptions.store');
        Route::get('/delete-subscription/{id}',[SubscriptionsController::class,'destroy'])->name('subscriptions.destroy');
        Route::get('/edit-subscription/{id}',[SubscriptionsController::class,'edit'])->name('subscriptions.edit');
        Route::post('/update-subscription',[SubscriptionsController::class,'update'])->name('subscriptions.update');

        // AdminProfile
        Route::get('/my-profile/{id}',[UserController::class,'editProfile'])->name('admin.profile');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('admin.profile.update');

        // Admin Settings
        Route::get('/settings',[AdminSettingsController::class,'index'])->name('admin.settings');
        Route::post('/settings-update',[AdminSettingsController::class,'update'])->name('update.admin.settings');


    });

});
