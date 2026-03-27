<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Models\Restaurant;
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

Route::get('/restaurants',function(){
    return view('restaurants');
});

Route::get('/restaurants/{id}', function ($id) {
    $restaurant = Restaurant::with('reviews.user')->findOrFail($id);
    
    return view('restaurantdetails', ['restaurant' => $restaurant]);
});
});

Route::get('/users', function () {
    return view('users');
})->middleware(['auth'])->name('users');

require __DIR__.'/auth.php';