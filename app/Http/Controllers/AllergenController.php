<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AllergenController extends Controller
{
    public function index()
    {
        $allergens = Allergen::all();
        
        return response()->json($allergens, 200);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Allergen::class);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:allergens,name',
        ], [
            'name.required' => 'Az allergén nevének megadása kötelező!',
            'name.max' => 'Az allergén neve maximum 100 karakter lehet!',
            'name.unique' => 'Ez az allergén már létezik a rendszerben!',
        ]);

        $allergen = Allergen::create($validated);

        return response()->json(['message' => 'Allergén sikeresen hozzáadva!', 'data' => $allergen], 201);
    }

    public function update(Request $request, Allergen $allergen)
    {
        Gate::authorize('update', $allergen);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:allergens,name,' . $allergen->id,
        ], [
            'name.required' => 'Az allergén nevének megadása kötelező!',
            'name.max' => 'Az allergén neve maximum 100 karakter lehet!',
            'name.unique' => 'Ez az allergén már létezik a rendszerben!',
        ]);

        $allergen->update($validated);

        return response()->json(['message' => 'Allergén sikeresen frissítve!'], 200);
    }

    public function destroy(Allergen $allergen)
    {
        Gate::authorize('delete', $allergen);

        $allergen->delete();
        
        return response()->json(['message' => 'Allergén sikeresen törölve!'], 200);
    }

    public function getMyAllergens() 
    {
        $user = Auth::user();

        return response()->json([
            'all_allergens' => Allergen::all(), 
            'user_has'      => $user ? $user->allergens()->pluck('allergens.id') : [] 
        ], 200);
    }


    public function updateMyAllergens(Request $request)
    {
        $validated = $request->validate([
            'allergen_ids' => 'nullable|array',
            'allergen_ids.*' => 'exists:allergens,id'
        ], [
            'allergen_ids.array' => 'Az allergének listája hibás formátumú!',
            'allergen_ids.*.exists' => 'A kiválasztott allergén nem létezik a rendszerben!'
        ]);

        $user = Auth::user();
        
        $user->allergens()->sync($request->allergen_ids ?? []);

        return response()->json(['message' => 'A saját allergén lista sikeresen frissítve!'], 200);
    }
}