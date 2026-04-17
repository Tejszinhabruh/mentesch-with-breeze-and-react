<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RestaurantController extends Controller
{

    public function index()
    {
        $restaurants = Restaurant::with('reviews.user', 'allergens')->paginate(15);
        
        return response()->json($restaurants, 200);
    }

    public function show($id)
    {
        $restaurant = Restaurant::with('reviews.user', 'allergens')->findOrFail($id);
        
        return response()->json($restaurant, 200);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Restaurant::class);

        $validated = $request->validate([
            'name' => 'required|string|max:250|min:5',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'name.required' => 'Az étterem nevének megadása kötelező!',
            'name.min' => 'Az étterem nevének legalább 5 karakter hosszúságúnak kell lennie!',
            'name.max' => 'Az étterem neve nem lehet hosszabb 250 karakternél!',
            'address.required' => 'A cím megadása kötelező!',
            'image.max'=> 'A kép maximum 2MB méretű lehet!',
            'image.mimes'=> 'Nem megfelelő képformátum! Támogatott formátumok: png, jpeg, jpg',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('restaurants', 'public');
        }
        
        $restaurant = Restaurant::create($validated);

        return response()->json([
            'message' => 'Étterem sikeresen létrehozva!', 
            'data' => $restaurant
        ], 201);
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        Gate::authorize('update', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:250|min:5',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'name.required' => 'Az étterem nevének megadása kötelező!',
            'name.min' => 'Az étterem nevének legalább 5 karakter hosszúságúnak kell lennie!',
            'name.max' => 'Az étterem neve nem lehet hosszabb 250 karakternél!',
            'address.required' => 'A cím megadása kötelező!',
            'image.max'=> 'A kép maximum 2MB méretű lehet!',
            'image.mimes'=> 'Nem megfelelő képformátum! Támogatott formátumok: png, jpeg, jpg',
        ]);

        $restaurant->update($validated);

        return response()->json(['message' => 'Az étterem adatai sikeresen frissítve!'], 200);
    }

    public function destroy(Restaurant $restaurant)
    {
        Gate::authorize('delete', $restaurant);

        $restaurant->delete();

        return response()->json(['message' => 'Az étterem sikeresen törölve!'], 200);
    }
}