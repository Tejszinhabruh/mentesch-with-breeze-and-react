<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        // Az admin mindenhez kap jogot (pl. törlés), KIVÉVE a módosítást ('update')
        if ($user->is_admin && $ability !== 'update') {
            return true;
        }

        return null;
    }

    /**
     * Bárki láthatja az értékelések listáját.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Bárki láthat egy konkrét értékelést.
     */
    public function view(?User $user, Review $review): bool
    {
        return true;
    }

    /**
     * Bármelyik bejelentkezett felhasználó írhat értékelést.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Csak az módosíthatja az értékelést, aki írta.
     */
    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id;
    }

    /**
     * Csak az törölheti az értékelést, aki írta.
     */
    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id;
    }
}