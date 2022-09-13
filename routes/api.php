<?php

use App\Http\Controllers;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillerDataController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CustomerGroupsController;
use App\Http\Controllers\DeliveryTimeController;
use App\Http\Controllers\DocumenTypesController;
use App\Http\Controllers\OrderSaleItemsController;
use App\Http\Controllers\OrderSalesController;
use App\Http\Controllers\PreferencesCategoriesController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductPreferencesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShopSettingsController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\SubZonesController;
use App\Http\Controllers\TaxRatesController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\UnitsPricesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\ZonesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/refreshToken', [AuthController::class,'refreshToken']);
    Route::get('/getUserData', [AuthController::class,'getUserData'])->middleware('auth:api');
    Route::post('/register', [AuthController::class,'register']);
    Route::get('/logout', [AuthController::class,'logout'])->middleware('auth:api');
});

Route::group(['prefix' => 'products'], function () {
    Route::post('/search', [ProductsController::class,'search']);
    Route::post('/productDetails', [ProductsController::class,'productDetails']);
    Route::post('/units', [UnitsController::class,'getUnits']);
    Route::get('/preferencesCategories', [PreferencesCategoriesController::class,'getPreferenceCategories']);
    Route::get('/preferences', [ProductPreferencesController::class,'getPreferences']);
    Route::post('/productUnitPrices', [UnitsPricesController::class,'getProductUnitsPrice']);
    Route::post('/productPreferences', [ProductPreferencesController::class,'getProductPreferences']);
    Route::get('/getCategories', [ProductCategoriesController::class,'getCategories']);
    Route::get('/getTaxRates', [TaxRatesController::class,'getTaxRates']);
});

Route::group(['prefix' => 'orders'], function () {
    Route::post('/create', [OrderSalesController::class,'create']);
    Route::post('/cancel', [OrderSalesController::class,'cancelPendingOrder']);
    Route::post('/customerOrders', [OrderSalesController::class,'customerOrders']);
    Route::post('/details', [OrderSaleItemsController::class,'orderDetails']);
    Route::post('/customerOrdersCount', [OrderSalesController::class,'customerOrdersCount']);

    
});

Route::group(['prefix' => 'applicationInit'], function () {
    Route::get('/initData', [ShopSettingsController::class,'getShopSettings']);

    
});

Route::group(['prefix' => 'wishList'], function () {
    Route::post('/addFavorite', [WishListController::class,'addFavorite']);
    Route::post('/removeFavorite', [WishListController::class,'removeFavorite']);
});


Route::group(['prefix' => 'biller'], function () {
    Route::post('/billerData', [BillerDataController::class,'billerData']);
});
Route::group(['prefix' => 'addresses'], function () {
    Route::post('/create', [AddressesController::class,'createCompanyAddress']);
});

Route::group(['prefix' => 'companies'], function () {
    Route::post('/verifyVatNo', [CompaniesController::class,'verifyDocument']);
    Route::get('/customerCompanyGroups', [CustomerGroupsController::class,'getCompanyCustomerGroups']);
    Route::get('/documentypes', [DocumenTypesController::class,'getDocumenTypes']);
    Route::post('/companyAddresses', [AddressesController::class,'getCompanyAddresses']);
    Route::post('/defaultAddressData', [AddressesController::class,'getDefaultAddressData']);
    Route::post('/addressData', [AddressesController::class,'getAddressData']);
    
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/verifyUserData', [UsersController::class,'verifyUserData']);
    Route::post('/updateUserData', [CompaniesController::class,'updateUserData']);
});


Route::group(['prefix' => 'deliveryTimes'], function () {
    Route::post('/avaiable', [DeliveryTimeController::class,'avaiableDeliveryTime']);
});
Route::group(['prefix' => 'locations'], function () {
    Route::get('/countries', [CountriesController::class,'getCountries']);
    Route::post('/countryStates', [StatesController::class,'getCountryStates']);
    Route::post('/stateCities', [CitiesController::class,'getStateCities']);
    Route::post('/cityZones', [ZonesController::class,'getCityZones']);
    Route::post('/zoneSubzones', [SubZonesController::class,'getSubzones']);
});
