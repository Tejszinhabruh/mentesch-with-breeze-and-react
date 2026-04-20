<?php

namespace Tests\Feature;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_write_a_review()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->post("/restaurants/{$restaurant->id}/reviews", [
            'rating' => 5,
            'comment' => 'Nagyon finom volt minden!',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('reviews', ['comment' => 'Nagyon finom volt minden!']);
    }



    public function test_validation_errors_when_creating_review()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->post("/restaurants/{$restaurant->id}/reviews", [
            'rating' => 10, 
            'comment' => 'Jo', 
        ]);
        
        $response->assertStatus(302)->assertSessionHasErrors(['rating', 'comment']);
    }



    public function test_user_can_update_own_review()
    {
        $user = User::factory()->create();

        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson("/api/reviews/{$review->id}", [
            'rating' => 4,
            'comment' => 'Mégsem volt annyira tökéletes.',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('reviews', ['rating' => 4]);
    }



    public function test_user_cannot_change_others_review()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->putJson("/api/reviews/{$review->id}", [
            'rating' => 1,
            'comment' => 'Hackeltem!',
        ]);

        $response->assertStatus(403);
    }



    public function test_admin_cannot_change_others_review()
    {
        $user = User::factory()->create();
        
        $admin = User::factory()->create(['is_admin' => true]);
        
        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->putJson("/api/reviews/{$review->id}", [
            'rating' => 3,
            'comment' => 'Admin által módosítva.',
        ]);

        $response->assertStatus(403);
    }



    public function test_user_can_delete_own_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user->id]);

        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/reviews/{$review->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }



    public function test_user_cannot_delete_others_review()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $review = Review::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->deleteJson("/api/reviews/{$review->id}");

        $response->assertStatus(403);
    }



    public function test_admin_can_delete_any_review()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $review = Review::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->delete("/reviews/{$review->id}");
        $response->assertStatus(302);
    }



    public function test_returns_404_for_non_existent_restaurant_or_review()
    {
        $user = User::factory()->create();

        $response1 = $this->actingAs($user)->postJson("/api/restaurants/9999/reviews", [
            'rating' => 5,
            'comment' => 'Teszt',
        ]);

        $response1->assertStatus(404);

        $response2 = $this->actingAs($user)->deleteJson("/api/reviews/9999");
        $response2->assertStatus(404);
    }
}