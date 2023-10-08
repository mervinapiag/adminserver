<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('shoes', ShoeController::class);
Route::apiResource('accessories', AccessoryController::class);
Route::apiResource('variants', ProductVariantController::class);
Route::apiResource('images', ProductImageController::class);

Route::get('shoes/{shoe}/variants', [ShoeController::class, 'getVariants']);

// Fetch images for a specific shoe
Route::get('shoes/{shoe}/images', [ShoeController::class, 'getImages']);

// Fetch images for a specific accessory
Route::get('accessories/{accessory}/images', [AccessoryController::class, 'getImages']);
