<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\Discount\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentOptionController;
use App\Http\Controllers\SpecialOfferController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SiteSettings\HelpCenterController;
use App\Http\Controllers\SiteSettings\SiteSettingsController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CartController;

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

// For login - No authentication required
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Protected routes - Requires authentication
Route::middleware(['auth:sanctum'])->group(function () {
    // For logout
    Route::post('logout', [AuthController::class, 'logout']);

    // For profile stuff
    Route::get('user/me', [UserController::class, 'me']);
    Route::post('user/update', [UserController::class, 'updateInfo']);

    // For admin only
    Route::middleware(['admin'])->group(function () {
        // For custom controller functions
        // Getting archived Announcements
        Route::get('announcements/archived', [AnnouncementController::class, 'getArchived']);
        Route::get('discounts/archived', [DiscountController::class, 'getArchived']);

        // For api resources
        Route::apiResources([
            'sites-settings' => SiteSettingsController::class,
            'help-centers' => HelpCenterController::class,
            'announcements' => AnnouncementController::class,
            'discounts' => DiscountController::class,
            'promotions' => PromotionController::class,
            'shoes' => ShoeController::class,
            'couriers' => CourierController::class,
            'customers' => CustomerController::class,
            'special-offers' => SpecialOfferController::class,
            'orders' => OrderController::class,
            'payment-options' => PaymentOptionController::class
        ]);

        Route::post('customers/{id}/suspend', [CustomerController::class, 'suspend']);
    });
});

// Your existing protected routes
Route::apiResources([
    'accessories' => AccessoryController::class,
    'variants' => ProductVariantController::class,
    'images' => ProductImageController::class,
]);

// Read-only Discount routes for 'customer'
Route::apiResource('discounts', DiscountController::class)->only([
    'index', 'show',
]);

// Read-only Promotion routes for 'customer'
Route::apiResource('discounts', PromotionController::class)->only([
    'index', 'show',
]);

Route::apiResource('shoes', ShoeController::class)->only([
    'index', 'show'
]);

Route::get('mix-and-match', [ShoeController::class, 'mixAndMatch']);

/* carts */

Route::get('/carts', '\App\Http\Controllers\CartController@index');

Route::post('/carts/store', [
    'uses' => '\App\Http\Controllers\CartController@store',
    'as' => 'carts.store'
]);

Route::post('/carts/{id}/update',
    ['as' => 'carts.update',
        'uses' => '\App\Http\Controllers\CartController@update']
);

Route::delete('/carts/{id}/delete',
    ['as' => 'carts.delete',
        'uses' => '\App\Http\Controllers\CartController@destroy']
);


Route::apiResource('couriers', CourierController::class)->only([
    'index', 'show'
]);

Route::apiResource('special-offers', SpecialOfferController::class)->only([
    'index', 'show'
]);

// Route::apiResource('orders', OrderController::class)->only([
//     'index', 'show'
// ]);

Route::get('shoes/{shoe}/variants', [ShoeController::class, 'getVariants']);
Route::get('shoes/{shoe}/images', [ShoeController::class, 'getImages']);
Route::get('accessories/{accessory}/images', [AccessoryController::class, 'getImages']);
