<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AllergenController;

  //----------------------------------------------//
 //                Publikus utak                 //
//----------------------------------------------//
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show']);
Route::get('/allergens', [AllergenController::class, 'index']);
Route::get('/restaurants', [RestaurantController::class, 'index']);


  //----------------------------------------------//
 //                Felhasználóknak               //
//----------------------------------------------//
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Csak értékelni és saját allergént menteni tud!
    Route::post('/restaurants/{restaurant}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    Route::post('/my-allergens', [AllergenController::class, 'updateMyAllergens']);

    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/restaurants', [RestaurantController::class, 'store']);
});
});


//----------------------------------------------//
//              CSAK ADMINOKNAK                 //
//----------------------------------------------//
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy']);

    Route::post('/allergens', [AllergenController::class, 'store']);
    Route::put('/allergens/{allergen}', [AllergenController::class, 'update']);
    Route::delete('/allergens/{allergen}', [AllergenController::class, 'destroy']);
});