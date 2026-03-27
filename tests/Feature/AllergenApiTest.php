<?php

namespace Tests\Feature;

use App\Models\Allergen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllergenApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_allergens()
    {
        Allergen::factory()->count(3)->create();

        $response = $this->getJson('/api/allergens');

        $response->assertStatus(200)->assertJsonCount(3);
    }



    public function test_admin_can_create_allergen()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->postJson('/api/allergens', [
            'name' => 'Glutén',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('allergens', ['name' => 'Glutén']);
    }



    public function test_normal_user_cannot_create_allergen()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->postJson('/api/allergens', [
            'name' => 'Laktóz',
        ]);

        $response->assertStatus(403);
    }



    public function test_validation_fails_if_allergen_name_is_not_unique()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Allergen::factory()->create(['name' => 'Szója']);

        $response = $this->actingAs($admin)->postJson('/api/allergens', [
            'name' => 'Szója', // Már létezik!
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('name');
    }



    public function test_admin_can_update_and_delete_allergen()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $allergen = Allergen::factory()->create(['name' => 'Régi név']);

        $updateResponse = $this->actingAs($admin)->putJson("/api/allergens/{$allergen->id}", [
            'name' => 'Új név',
        ]);
        $updateResponse->assertStatus(200);
        $this->assertDatabaseHas('allergens', ['name' => 'Új név']);

        $deleteResponse = $this->actingAs($admin)->deleteJson("/api/allergens/{$allergen->id}");
        $deleteResponse->assertStatus(200);
        $this->assertDatabaseMissing('allergens', ['id' => $allergen->id]);
    }



    public function test_normal_user_cannot_update_or_delete_allergen()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $allergen = Allergen::factory()->create();

        $this->actingAs($user)->putJson("/api/allergens/{$allergen->id}", ['name' => 'Teszt'])->assertStatus(403);
        $this->actingAs($user)->deleteJson("/api/allergens/{$allergen->id}")->assertStatus(403);
    }







    // --- SAJÁT ALLERGÉN LISTA TESZTEK --- //

    public function test_user_can_sync_allergens_to_profile()
    {
        $user = User::factory()->create();
        $allergen1 = Allergen::factory()->create();
        $allergen2 = Allergen::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/profile/allergens', [
            'allergen_ids' => [$allergen1->id, $allergen2->id],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('allergenlists', 2);
    }



    public function test_user_can_clear_their_allergen_list()
    {
        $user = User::factory()->create();
        $allergen = Allergen::factory()->create();
        $user->allergens()->attach($allergen->id);

        $response = $this->actingAs($user)->putJson('/api/profile/allergens', [
            'allergen_ids' => [],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('allergenlists', 0);
    }



    public function test_fails_when_sending_invalid_allergen_id()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/profile/allergens', [
            'allergen_ids' => [9999],
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('allergen_ids.0');
    }



    public function test_guest_cannot_update_allergens()
    {
        $response = $this->putJson('/api/profile/allergens', [
            'allergen_ids' => [],
        ]);

        $response->assertStatus(401);
    }
}