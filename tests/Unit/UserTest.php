<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function a_user_has_wishes() {
        // given we have a user and they have some wishes
        $user = factory('App\User')->create();
        $wishes = factory('App\Wish')->create([
            'user_id' => $user->id
        ]);

        // when we try to get the users wishes
        $result = $user->fresh()->wishes; // refresh the user object from the database first

        // we should see an instance of our wish model
        $this->assertInstanceOf('App\Wish',$result[0]);
    }
}
