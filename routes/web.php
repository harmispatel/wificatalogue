<?php

use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingInfoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ShopBannerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopQrController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\ThemeController;
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
        Route::get('/access-clients/{id}',[UserController::class,'clientAccess'])->name('clients.access');
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
        Route::get('/my-profile/{id}',[UserController::class,'myProfile'])->name('admin.profile.view');
        Route::get('/edit-profile/{id}',[UserController::class,'editProfile'])->name('admin.profile.edit');
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
        Route::post('sorting-categories',[CategoryController::class,'sorting'])->name('categories.sorting');
        Route::get('delete-categories-image/{id}',[CategoryController::class,'deleteCategoryImage'])->name('categories.delete.image');

        // Items
        Route::get('items/{id?}',[ItemsController::class,'index'])->name('items');
        Route::post('store-items',[ItemsController::class,'store'])->name('items.store');
        Route::post('delete-items',[ItemsController::class,'destroy'])->name('items.delete');
        Route::post('status-items',[ItemsController::class,'status'])->name('items.status');
        Route::post('search-items',[ItemsController::class,'searchItems'])->name('items.search');
        Route::post('edit-items',[ItemsController::class,'edit'])->name('items.edit');
        Route::post('update-items',[ItemsController::class,'update'])->name('items.update');
        Route::post('sorting-items',[ItemsController::class,'sorting'])->name('items.sorting');
        Route::get('delete-items-image/{id}',[ItemsController::class,'deleteItemImage'])->name('items.delete.image');


        // Designs
        Route::get('/design-logo', [DesignController::class,'logo'])->name('design.logo');
        Route::post('/design-logo-upload', [DesignController::class,'logoUpload'])->name('design.logo.upload');
        Route::get('/design-logo-delete', [DesignController::class,'deleteLogo'])->name('design.logo.delete');

        Route::post('/design-intro-status', [DesignController::class,'introStatus'])->name('design.intro.status');
        Route::post('/design-intro-icon', [DesignController::class,'introIconUpload'])->name('design.intro.icon');
        Route::post('/design-intro-duration', [DesignController::class,'introDuration'])->name('design.intro.duration');

        Route::get('/design-cover', [DesignController::class,'cover'])->name('design.cover');
        Route::get('/design-cover-delete', [DesignController::class,'deleteCover'])->name('design.cover.delete');

        Route::get('/design-banner', [ShopBannerController::class,'index'])->name('design.banner');
        Route::post('/design-banner-update', [ShopBannerController::class,'update'])->name('design.banner.update');
        Route::get('/design-banner-delete/{key}', [ShopBannerController::class,'deleteBanner'])->name('design.banner.delete');

        Route::get('/design-general-info', [DesignController::class,'generalInfo'])->name('design.general-info');
        Route::post('/design-generalInfoUpdate', [DesignController::class,'generalInfoUpdate'])->name('design.generalInfoUpdate');

        // Billing Infor
        Route::get('billing-info',[BillingInfoController::class, 'billingInfo'])->name('billing.info');
        Route::post('billing-info-update',[BillingInfoController::class, 'updateBillingInfo'])->name('update.billing.info');

        // Languages
        Route::get('/languages', [LanguageController::class,'index'])->name('languages');
        Route::post('/language-set-primary', [LanguageController::class,'setPrimaryLanguage'])->name('language.set-primary');
        Route::post('/language-set-additional', [LanguageController::class,'setAdditionalLanguages'])->name('language.set-additional');
        Route::post('/language-delete-additional', [LanguageController::class,'deleteAdditionalLanguage'])->name('language.delete-additional');
        Route::post('/language-change-status', [LanguageController::class,'changeLanguageStatus'])->name('language.changeStatus');
        Route::post('/language-categorydetails', [LanguageController::class,'getCategoryDetails'])->name('language.categorydetails');
        Route::post('/language-update-catdetails', [LanguageController::class,'updateCategoryDetails'])->name('language.update-category-details');
        Route::post('/language-itemdetails', [LanguageController::class,'getItemDetails'])->name('language.itemdetails');
        Route::post('/language-update-itemdetails', [LanguageController::class,'updateItemDetails'])->name('language.update-item-details');


        // Shop QrCode
        Route::get('/qrcode', [ShopQrController::class,'index'])->name('qrcode');
        Route::post('/qrcode-settings', [ShopQrController::class,'QrCodeSettings'])->name('qrcode.settings');
        Route::post('/qrcode-update-settings', [ShopQrController::class,'QrCodeUpdateSettings'])->name('qrcode.update.settings');

        // ClientProfile
        Route::get('/my-profile/{id}',[UserController::class,'myProfile'])->name('client.profile.view');
        Route::get('/edit-profile/{id}',[UserController::class,'editProfile'])->name('client.profile.edit');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('client.profile.update');
        Route::get('/delete-profile-picture',[UserController::class,'deleteProfilePicture'])->name('client.delete.profile.picture');

        // Delete Shop Logo
        Route::get('delete-shop-logo',[ShopController::class, 'deleteShopLogo'])->name('shop.delete.logo');

        // Tags
        Route::get('tags',[TagsController::class,'index'])->name('tags');
        Route::post('delete-tags',[TagsController::class,'destroy'])->name('tags.destroy');
        Route::post('edit-tags',[TagsController::class,'edit'])->name('tags.edit');
        Route::post('update-tags',[TagsController::class,'update'])->name('tags.update');
        Route::post('sorting-tags',[TagsController::class,'sorting'])->name('tags.sorting');
        Route::post('edit-language-tags',[TagsController::class,'editTag'])->name('language.tags.edit');
        Route::post('update-language-tags',[TagsController::class,'updateTag'])->name('language.tags.update');

        // Preview
        Route::get('/preview',[PreviewController::class,'index'])->name('preview');

        // Statistic
        Route::get('/statistics',[StatisticsController::class,'index'])->name('statistics');

        // contact us
        Route::get('/contact',[ContactController::class,'index'])->name('contact');

        // Themes
        Route::get('/design-theme', [ThemeController::class,'index'])->name('design.theme');
        Route::get('/design-theme-preview/{id}', [ThemeController::class,'themePrview'])->name('design.theme-preview');
        Route::get('/design-create-theme', [ThemeController::class,'create'])->name('design.theme-create');
        Route::post('/design-store-theme', [ThemeController::class,'store'])->name('design.theme-store');
        Route::post('/design-update-theme', [ThemeController::class,'update'])->name('design.theme-update');
        Route::post('/change-theme', [ThemeController::class,'changeTheme'])->name('theme.change');
        Route::get('/delete-theme/{id}', [ThemeController::class,'destroy'])->name('theme.delete');
        Route::get('/clone-theme/{id}', [ThemeController::class,'cloneView'])->name('theme.clone');

    });
});


// Shops Preview
Route::get('/{shop_slug}',[ShopController::class,'index'])->name('restaurant');
Route::get('{shop_slug}/items/{catID}',[ShopController::class,'itemPreview'])->name('items.preview');
Route::post('shop-locale-change',[ShopController::class,'changeShopLocale'])->name('shop.locale.change');
Route::post('search-shop-categories',[ShopController::class,'searchCategories'])->name('shop.categories.search');

// Change Backend Language
Route::post('/change-backend-language', [DashboardController::class, 'changeBackendLanguage'])->name('change.backend.language');
