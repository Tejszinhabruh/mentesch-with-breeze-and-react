<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\ProfileController;


// ==========================================
// 1. PUBLIKUS VÉGPONTOK (Nem kell bejelentkezés)
// ==========================================
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show']);
Route::get('/allergens', [AllergenController::class, 'index']);


// ==========================================
// 2. BEJELENTKEZÉSHEZ KÖTÖTT VÉGPONTOK (Sima felhasználók + Admin)
// ==========================================
Route::middleware('auth:sanctum', 'verified')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user()->load('allergens'); 
    });
    Route::put('/profile/allergens', [AllergenController::class, 'updateMyAllergens']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::post('/restaurants/{restaurantId}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy']);

    Route::post('/allergens', [AllergenController::class, 'store']);
    Route::put('/allergens/{allergen}', [AllergenController::class, 'update']);
    Route::delete('/allergens/{allergen}', [AllergenController::class, 'destroy']);
});


// ==========================================
// 3. KIZÁRÓLAG ADMIN VÉGPONTOK
// ==========================================
Route::middleware(['auth:sanctum', IsAdminMiddleware::class])->group(function () {

    Route::get('/admin/users', [UserController::class, 'index']);
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy']);
    Route::get('/admin/dashboard-stats', [AdminController::class, 'stats']);

});