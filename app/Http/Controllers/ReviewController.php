<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        // 1. Validáció
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ], [
            'rating.required' => 'Az értékelés megadása kötelező!',
            'rating.integer' => 'Az értékelésnek számnak (1-5) kell lennie!',
            'rating.min' => 'Az értékelés minimum 1 csillag lehet!',
            'rating.max' => 'Az értékelés maximum 5 csillag lehet!',
            'comment.required' => 'A szöveges vélemény megadása kötelező!',
            'comment.min' => 'A véleménynek legalább 5 karakterből kell állnia!',
            'comment.max' => 'A vélemény túl hosszú (maximum 1000 karakter)!',
        ]);

        // 2. Mentés a bejelentkezett felhasználó ID-jával
        $review = Review::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurantId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'message' => 'Értékelés sikeresen elmentve!', 
            'data' => $review
        ], 201);
    }

    public function update(Request $request, Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            return response()->json(['message' => 'Nincs jogosultságod módosítani ezt az értékelést!'], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ], [
            'rating.required' => 'Az értékelés megadása kötelező!',
            'rating.integer' => 'Az értékelésnek számnak (1-5) kell lennie!',
            'rating.min' => 'Az értékelés minimum 1 csillag lehet!',
            'rating.max' => 'Az értékelés maximum 5 csillag lehet!',
            'comment.required' => 'A szöveges vélemény megadása kötelező!',
            'comment.min' => 'A véleménynek legalább 5 karakterből kell állnia!',
            'comment.max' => 'A vélemény túl hosszú (maximum 1000 karakter)!',
        ]);

        $review->update($validated);

        return response()->json(['message' => 'Értékelés sikeresen frissítve!'], 200);
    }

    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
            return response()->json(['message' => 'Nincs jogosultságod törölni ezt az értékelést!'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Értékelés sikeresen törölve!'], 200);
    }
}