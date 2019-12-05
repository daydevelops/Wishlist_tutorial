<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrowseWishListTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function a_guest_can_see_a_list_of_users_and_their_wishes() {
        // create 3 wishes each with a different user
        $wishes = factory('App\Wish',3)->create();
        $users = User::all();

        // make a get request to the home page
        $response = $this->get('/');

        // assert that we see each user
        $response->assertSee($users[0]->name);
        $response->assertSee($users[1]->name);
        $response->assertSee($users[2]->name);

        // and each wish name
        $response->assertSee($wishes[0]->name);
        $response->assertSee($wishes[1]->name);
        $response->assertSee($wishes[2]->name);
    }

    /** @test */
    public function a_guest_can_visit_another_users_profile() {
        // given we have a user with some wishes
        $user = factory('App\User')->create();
        $wishes = factory('App\Wish',5)->create(['user_id'=>$user->id]);

        // when we visit the wishlist for that user
        $response = $this->get('/wishlist/'.$user->id);

        // we should see the users info and their wishes
        $response->assertSee($user->name);
        $response->assertSee($wishes[0]->name);
        $response->assertSee($wishes[0]->description);
        $response->assertSee($wishes[0]->price);
    }
}
