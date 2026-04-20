<?php

namespace Tests\Unit;

use App\Models\Allergen;

use PHPUnit\Framework\TestCase;

class AllergenUnitTest extends TestCase
{
    /** @test */
    public function can_create_allergen_model_in_memory(){
        $allergen = new Allergen([
            'name'=>"Glutén"
        ]);

        $this->assertEquals('Glutén', $allergen->name);

        $this->assertNotEmpty($allergen->name);
    }
}
