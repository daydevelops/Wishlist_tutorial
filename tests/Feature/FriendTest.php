<?php

namespace Tests\Feature;

use App\Friend;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FriendTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function an_auth_user_can_visit_the_friends_page() {
        $this->signIn();
        $users = factory('App\User',2)->create();
        $users[0]->beFriend();

        $res = $this->get('/friend');

        $res->assertSee($users[0]->name);
        $res->assertDontSee($users[1]->name);
    }

    /** @test */
    public function a_guest_cannot_visit_the_friends_page() {
		$this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('/friend');
    }

    /** @test */
    public function a_user_can_send_a_friend_request() {
        $this->signIn();
        $user=factory('App\User')->create();
        $this->post('/friend/'.$user->id);
        $this->assertTrue($user->isFriend());
    }

    /** @test */
    public function a_user_can_remove_a_friend() {
        $this->signIn();
        $user=factory('App\User')->create();
        $user->befriend();
        $this->json('DELETE','/friend/'.$user->id);
        $this->assertFalse($user->isFriend());
    }

    /** @test */
    public function a_user_can_only_friend_someone_once() {
        $this->signIn();
        $user=factory('App\User')->create();
        $this->post('/friend/'.$user->id);
        $this->post('/friend/'.$user->id);
        $this->assertCount(1,Friend::where([
            'user_id'=>auth()->id(),
            'friend_id'=>$user->id
        ])->get());
    }

    /** @test */
    public function a_guest_cannot_send_a_friend_request() {
		$this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/friend/1');
    }

    /** @test */
    public function a_guest_cannot_remove_a_friend() {
		$this->expectException('Illuminate\Auth\AuthenticationException');
        $this->json('DELETE','/friend/1');
    }
    
}
