<?php

namespace Tests\Unit;

use App\Models\Review;
use PHPUnit\Framework\TestCase;

class ReviewUnitTest extends TestCase
{
    /** @test */
    public function formats_the_comment_correctly_if_we_had_a_mutator()
    {
        $review = new Review(['comment' => '   nagyon jó hely!   ']);
        
        $this->assertNotEmpty($review->comment);
    }
}
