<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AllergenController;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('main'); 
})->name('dashboard');

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/users', function () {
        $users = User::all();
        return view('users',['users'=>$users]);
    });
    Route::delete('/users/{user}',[UserController::class,'destroy']);

    Route::get('/allergens', function () {
        return view('allergens');
    });
    Route::delete('/allergens/{allergen}',[AllergenController::class,'destroy']);

    Route::get('/myallergenlist', function () {
        return view('myallergenlist');
    });

    Route::get('/restaurants',function(){
        return view('restaurants');
    });

    Route::get('/restaurants/{id}', function ($id) {
        $restaurant = Restaurant::with('reviews.user')->withAvg('reviews as average_rating', 'rating')->findOrFail($id);

        return view('restaurantdetails', ['restaurant' => $restaurant]);
    });

    Route::post('/restaurants/{restaurantId}/reviews', [ReviewController::class, 'store']);
    Route::delete('restaurants/{restaurant}',[RestaurantController::class,'destroy']);

    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
});

Route::get('/my-allergens-list', [AllergenController::class, 'getMyAllergens']);
Route::post('/my-allergens-update', [AllergenController::class, 'updateMyAllergens']);

require __DIR__.'/auth.php';