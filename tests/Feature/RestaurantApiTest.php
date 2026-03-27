<?php

namespace Tests\Feature;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RestaurantApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_restaurants()
    {
        Restaurant::factory()->count(5)->create();

        $response = $this->getJson('/api/restaurants');
        $response->assertStatus(200);

        // A konkrét étterem lekérdezése is menjen
        $restaurant = Restaurant::first();
        $this->getJson("/api/restaurants/{$restaurant->id}")->assertStatus(200);
    }

    public function test_admin_can_create_update_delete_restaurant()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Létrehozás
        $createResponse = $this->actingAs($admin)->postJson('/api/restaurants', [
            'name' => 'Teszt Étterem',
            'address' => '1234 Budapest, Fő utca 1.',
        ]);
        $createResponse->assertStatus(201);
        $restaurantId = $createResponse->json('data.id');

        $this->actingAs($admin)->putJson("/api/restaurants/{$restaurantId}", [
            'name' => 'Módosított Étterem',
            'address' => '1234 Budapest, Fő utca 2.',
        ])->assertStatus(200);

        // Törlés
        $this->actingAs($admin)->deleteJson("/api/restaurants/{$restaurantId}")->assertStatus(200);
        $this->assertDatabaseMissing('restaurants', ['id' => $restaurantId]);
    }

    public function test_normal_user_cannot_modify_restaurants()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $restaurant = Restaurant::factory()->create();

        $this->actingAs($user)->postJson('/api/restaurants', ['name' => 'X', 'address' => 'Y'])->assertStatus(403);
        $this->actingAs($user)->putJson("/api/restaurants/{$restaurant->id}", ['name' => 'X', 'address' => 'Y'])->assertStatus(403);
        $this->actingAs($user)->deleteJson("/api/restaurants/{$restaurant->id}")->assertStatus(403);
    }

    public function test_restaurant_image_upload_validation()
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $badFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        
        $response = $this->actingAs($admin)->postJson('/api/restaurants', [
            'name' => 'Képes Étterem',
            'address' => 'Cím',
            'image' => $badFile,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('image');

        $goodFile = UploadedFile::fake()->image('photo.jpg');
        
        $successResponse = $this->actingAs($admin)->postJson('/api/restaurants', [
            'name' => 'Képes Étterem',
            'address' => 'Cím',
            'image' => $goodFile,
        ]);

        $successResponse->assertStatus(201);
    }
}