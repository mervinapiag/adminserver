<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController; 
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductImageController;

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
});

        // Your existing protected routes
        Route::apiResource('shoes', ShoeController::class);
        Route::apiResource('accessories', AccessoryController::class);
        Route::apiResource('variants', ProductVariantController::class);
        Route::apiResource('images', ProductImageController::class);
    
        Route::get('shoes/{shoe}/variants', [ShoeController::class, 'getVariants']);
        Route::get('shoes/{shoe}/images', [ShoeController::class, 'getImages']);
        Route::get('accessories/{accessory}/images', [AccessoryController::class, 'getImages']);
