<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Allergen;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('hu_HU');

        $testUser = User::create([
            'username' => 'Admin',
            'email' => 'admin@admin.hu',
            'password' => bcrypt('jelszo123'),
            'is_admin' => true,
        ]);
        $users[] = $testUser;

        for ($i = 0; $i < 10; $i++) {
            $users[] = User::create([
                'username' => $faker->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('jelszo123'),
                'is_admin' => false,
            ]);
        }

        $restaurants = [];
        for ($i = 0; $i < 50; $i++) {
            $restaurants[] = Restaurant::create([
                'name' => $faker->company() . ' Étterem', 
                'address' => $faker->address()
            ]);
        }

        $allergens = [];
        $allergenNames = ['Glutén', 'Laktóz', 'Mogyoró', 'Szója', 'Tojás', 'Rákféle', 'Hal', 'Mustár', 'Szezámmag', 'Zeller'];
        
        foreach ($allergenNames as $name) {
            $allergens[] = Allergen::create([
                'name' => $name,
                'desc' => $faker->sentence(6),
                'replist' => $faker->words(3, true)
            ]);
        }

        for ($i = 0; $i < 150; $i++) {
            Review::create([
                'comment' => $faker->realText(100), 
                'rating' => $faker->numberBetween(1, 5),
                'user_id' => $faker->randomElement($users)->id, 
                'restaurant_id' => $faker->randomElement($restaurants)->id 
            ]);
        }

    
        foreach ($users as $user) {
            $randomAllergenIds = $faker->randomElements(array_column($allergens, 'id'), rand(0, 3));
            $user->allergens()->attach($randomAllergenIds);
        }
    }
}