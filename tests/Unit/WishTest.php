<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishTest extends TestCase
{

    use DatabaseMigrations;
    
    /** @test */
    public function a_wish_can_be_purchased() {
        $wish = factory('App\Wish')->create();
        $this->assertNull($wish->purchased_by);
        $this->signIn();
        $wish->purchase();
        $this->assertEquals(auth()->id(),$wish->fresh()->purchased_by);
    }

    /** @test */
    public function a_wish_can_be_unpurchased() {
        $this->signIn();
        $wish = factory('App\Wish')->create([
            'purchased_by'=>auth()->id()
        ]);
        $wish->unpurchase();
        $this->assertNull($wish->fresh()->purchased_by);
    }
}
