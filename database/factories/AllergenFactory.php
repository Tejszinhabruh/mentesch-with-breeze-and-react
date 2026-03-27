<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AllergenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' allergén', 
        ];
    }
}