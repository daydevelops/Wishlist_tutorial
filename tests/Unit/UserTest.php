<?php

namespace Tests\Unit;

use App\Friend;
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

    /** @test */
    public function a_user_has_friends() {
        $users = factory('App\User',2)->create();
        Friend::create([
            'user_id'=>$users[0]->id,
            'friend_id'=>$users[1]->id
        ]);
        $friends = $users[0]->friends;

        $this->assertInstanceOf('App\User',$friends[0]);
    }

    /** @test */
    public function a_user_knows_if_someone_is_a_friend() {
        $this->signIn();
        $users = factory('App\User',2)->create();
        Friend::create([
            'user_id'=>auth()->id(),
            'friend_id'=>$users[0]->id
        ]);

        $this->assertTrue($users[0]->isFriend());
        $this->assertFalse($users[1]->isFriend());
    }

    /** @test */
    public function a_user_can_add_a_friend() {
        $this->signIn();
        $user = factory('App\User')->create();
        $user->befriend();
        $this->assertEquals(auth()->user()->friends[0]->name,$user->name);
    }

    /** @test */
    public function a_user_can_unfriend_someone() {
        $this->signIn();
        $user = factory('App\User')->create();
        $user->befriend();
        $this->assertEquals(auth()->user()->friends[0]->name,$user->name);
        $user->unfriend();
        $this->assertEmpty(auth()->user()->fresh()->friends);
    }
}
