<?php

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/allergens', function () {
    return view('allergens');
});
Route::get('/myallergenlist', function () {
    return view('myallergenlist');
});

Route::get('/api/allergens-data', [AllergenController::class, 'getAllergensData']);
Route::get('/api/my-allergens-list', [AllergenController::class, 'index']);
Route::post('/api/my-allergens-update', [AllergenController::class, 'updateMyAllergens']);

Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show']);
});

require __DIR__.'/auth.php';
