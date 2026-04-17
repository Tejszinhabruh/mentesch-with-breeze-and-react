<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ], [
            'rating.required' => 'Az értékelés megadása kötelező!',
            'rating.integer' => 'Az értékelésnek 1 és 5 között kell lennie!',
            'rating.min' => 'Az értékelés minimum 1 csillag lehet!',
            'rating.max' => 'Az értékelés maximum 5 csillag lehet!',
            'comment.required' => 'A szöveges vélemény megadása kötelező!',
            'comment.min' => 'A véleménynek legalább 5 karakterből kell állnia!',
            'comment.max' => 'A vélemény túl hosszú (maximum 1000 karakter)!',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurantId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Értékelés sikeresen elmentve!');
    }

    public function update(Request $request, Review $review)
    {
        Gate::authorize('update', $review);

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
        Gate::authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Értékelés sikeresen törölve!');
    }
}