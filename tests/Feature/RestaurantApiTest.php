<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RestaurantApiTest extends TestCase
{
    // Ez a sor gondoskodik róla, hogy a tesztek ne szemeteljék tele a fő adatbázisod
    use RefreshDatabase; 

    /**
     * 1. Teszt: Bárki lekérdezheti az éttermek listáját (Publikus végpont).
     */
    public function test_anyone_can_fetch_restaurants_list(): void
    {
        $response = $this->get('/api/restaurants');

        $response->assertStatus(200);
    }

    /**
     * 2. Teszt: Vendég (nem bejelentkezett) felhasználó NEM hozhat létre éttermet.
     */
    public function test_guest_cannot_create_restaurant(): void
    {
        $response = $this->postJson('/api/restaurants', [
            'name' => 'Teszt Étterem',
            'address' => '1234 Budapest, Teszt utca 1.',
        ]);

        $response->assertStatus(401);
    }

    /**
     * 3. Teszt: Admin felhasználó létrehozhat éttermet.
     */
    public function test_admin_can_create_restaurant(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $restaurantData = [
            'name' => 'Kiváló Teszt Étterem',
            'address' => '1111 Budapest, Admin utca 5.',
        ];

        $response = $this->actingAs($admin, 'sanctum')
                         ->postJson('/api/restaurants', $restaurantData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('restaurants', [
            'name' => 'Kiváló Teszt Étterem',
        ]);
    }
}