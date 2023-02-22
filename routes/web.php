<?php

use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TagsController;
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
    return redirect('/');
    // dd("Cache is cleared");
});


// Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('doLogin');
// Logout
Route::get('/logout', [AuthController::class,'logout'])->name('logout');


Route::group(['prefix' => 'admin'], function ()
{
    // If Auth Login
    Route::group(['middleware' => ['auth','is_admin']], function ()
    {
        // Admin Dashboard
        Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');

        // Admins
        Route::get('/admins',[UserController::class,'AdminUsers'])->name('admins');
        Route::get('/new-admins',[UserController::class,'NewAdminUser'])->name('admins.add');
        Route::post('/store-admins',[UserController::class,'storeNewAdmin'])->name('admins.store');
        Route::get('/delete-admins/{id}',[UserController::class,'destroyAdminUser'])->name('admins.destroy');
        Route::get('/edit-admins/{id}',[UserController::class,'editAdmin'])->name('admins.edit');
        Route::post('/update-admins',[UserController::class,'updateAdmin'])->name('admins.update');

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

        // Ingredients
        Route::get('/ingredients',[IngredientController::class,'index'])->name('ingredients');
        Route::get('/new-ingredients',[IngredientController::class,'insert'])->name('ingredients.add');
        Route::post('/store-ingredients',[IngredientController::class,'store'])->name('ingredients.store');
        Route::get('/delete-ingredients/{id}',[IngredientController::class,'destroy'])->name('ingredients.destroy');
        Route::get('/edit-ingredients/{id}',[IngredientController::class,'edit'])->name('ingredients.edit');
        Route::post('/update-ingredients',[IngredientController::class,'update'])->name('ingredients.update');
        Route::post('/status-ingredients',[IngredientController::class,'changeStatus'])->name('ingredients.status');

        // AdminProfile
        Route::get('/my-profile/{id}',[UserController::class,'editProfile'])->name('admin.profile');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('admin.profile.update');

        // Admin Settings
        Route::get('/settings',[AdminSettingsController::class,'index'])->name('admin.settings');
        Route::post('/settings-update',[AdminSettingsController::class,'update'])->name('update.admin.settings');


        // Languages
        Route::post('/save-language',[LanguagesController::class,'saveAjax'])->name('languages.save.ajax');

    });

});


Route::group(['prefix' => 'client'], function()
{
    // If Auth Login
    Route::group(['middleware' => 'auth'], function ()
    {
        // Admin Dashboard
        Route::get('dashboard', [DashboardController::class,'clientDashboard'])->name('client.dashboard');

        // Categories
        Route::get('categories',[CategoryController::class,'index'])->name('categories');
        Route::post('store-categories',[CategoryController::class,'store'])->name('categories.store');
        Route::post('delete-categories',[CategoryController::class,'destroy'])->name('categories.delete');
        Route::post('edit-categories',[CategoryController::class,'edit'])->name('categories.edit');
        Route::post('update-categories',[CategoryController::class,'update'])->name('categories.update');
        Route::post('status-categories',[CategoryController::class,'status'])->name('categories.status');
        Route::post('search-categories',[CategoryController::class,'searchCategories'])->name('categories.search');

        // Items
        Route::get('items/{id}',[ItemsController::class,'index'])->name('items');
        Route::post('store-items',[ItemsController::class,'store'])->name('items.store');
        Route::post('delete-items',[ItemsController::class,'destroy'])->name('items.delete');
        Route::post('status-items',[ItemsController::class,'status'])->name('items.status');
        Route::post('search-items',[ItemsController::class,'searchItems'])->name('items.search');
        Route::post('edit-items',[ItemsController::class,'edit'])->name('items.edit');
        Route::post('update-items',[ItemsController::class,'update'])->name('items.update');

        // Designs
        Route::get('/design', [MenuController::class,'index'])->name('design');

        // ClientProfile
        Route::get('/my-profile/{id}',[UserController::class,'editProfile'])->name('client.profile');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('client.profile.update');

        // Tags
        Route::post('delete-tags',[TagsController::class,'destroy'])->name('tags.destroy');
        Route::post('edit-tags',[TagsController::class,'edit'])->name('tags.edit');
        Route::post('update-tags',[TagsController::class,'update'])->name('tags.update');

    });
});
