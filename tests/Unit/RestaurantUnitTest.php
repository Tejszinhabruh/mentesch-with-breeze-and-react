<?php

namespace Tests\Unit;

use App\Models\Restaurant;

use PHPUnit\Framework\TestCase;

class RestaurantUnitTest extends TestCase
{
    /** @test */
    public function can_create_a_restaurant_model_in_memory()
    {
        $restaurant = new Restaurant([
            'name' => 'Teszt Étterem',
            'address' => '1234 Budapest, Teszt utca 1.',
        ]);

        $this->assertEquals('Teszt Étterem', $restaurant->name);
        $this->assertEquals('1234 Budapest, Teszt utca 1.', $restaurant->address);
    }
}
