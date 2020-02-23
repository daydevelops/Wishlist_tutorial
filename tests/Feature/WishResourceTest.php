<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishResourceTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_purchase_a_wish() {
        $this->signIn();
        $wish = factory('App\Wish')->create();
        $this->json('PATCH','/wish/'.$wish->id.'/purchase');
        $this->assertEquals(auth()->id(),$wish->fresh()->purchased_by);
    }

    /** @test */
    public function a_guest_connot_purchase_a_wish() {
        $wish = factory('App\Wish')->create();
        $this->withExceptionHandling()->json('PATCH','/wish/'.$wish->id.'/purchase')->assertStatus(401);
        $this->assertNull($wish->fresh()->purchased_by);
    }

    /** @test */
    public function a_wish_cannot_be_purchased_by_its_owner() {
        $this->signIn();
        $wish = factory('App\Wish')->create(['user_id'=>auth()->id()]);
        $this->withExceptionHandling()->json('PATCH','/wish/'.$wish->id.'/purchase');
        $this->assertNull($wish->fresh()->purchased_by);
    }

    /** @test */
    public function a_wish_can_only_be_purchased_once() {
        $this->signIn();
        $wish = factory('App\Wish')->create();
        $this->withExceptionHandling()->json('PATCH','/wish/'.$wish->id.'/purchase');
        $original_purchaser = $wish->fresh()->purchased_by;
        $this->assertEquals(auth()->id(),$original_purchaser);
        // sign in as a new user and purchase again
        $this->signIn();
        $this->withExceptionHandling()->json('PATCH','/wish/'.$wish->id.'/purchase');
        $this->assertEquals($wish->fresh()->purchased_by,$original_purchaser);
    }

    /** @test */
    public function a_wish_can_be_unpurchased() {
        $this->signIn();
        $wish = factory('App\Wish')->create();
        $this->json('PATCH','/wish/'.$wish->id.'/purchase');
        $this->assertEquals(auth()->id(),$wish->fresh()->purchased_by);

        $this->json('PATCH','/wish/'.$wish->id.'/unpurchase');
        $this->assertNull($wish->fresh()->purchased_by);
    }

    /** @test */
    public function a_wish_can_only_be_unpurchased_by_its_purchaser() {
        $this->signIn();
        $wish = factory('App\Wish')->create();
        $this->withExceptionHandling()->json('PATCH','/wish/'.$wish->id.'/purchase');
        $original_purchaser = $wish->fresh()->purchased_by;
        $this->assertEquals(auth()->id(),$original_purchaser);
        // sign in as a new user and unpurchase
        $this->signIn();
        $this->withExceptionHandling()->json('PATCH','/wish/'.$wish->id.'/unpurchase');
        $this->assertEquals($wish->fresh()->purchased_by,$original_purchaser);
    }

    /** @test */
    public function guests_cannot_delete_wishes() {
        $wish = factory('App\Wish')->create();
		$this->withExceptionHandling()->json('DELETE','/wish/'.$wish->id)->assertStatus(401);
    }

    /** @test */
    public function a_user_can_not_delete_another_users_wish() {
        $this->signIn();
        $wish = factory('App\Wish')->create();
		$this->withExceptionHandling()->json('DELETE','/wish/'.$wish->id)->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_their_own_wish() {
        $this->signIn();
        $wishes = factory('App\Wish',2)->create(['user_id'=>auth()->id()]);
        $response = $this->json('DELETE','/wish/'.$wishes[0]->id);
        $this->assertDatabaseMissing('wishes',['id'=>$wishes[0]->id]);
        $this->assertDatabaseHas('wishes',['id'=>$wishes[1]->id]);
    }

    /** @test */
    public function a_user_can_create_a_wish() {
        $this->signIn();
        $wish = [
            'name' => 'testing',
            'description' => 'testing123',
            'desire' => 2,
            'is_url' => 0
        ];
        $this->post('/wish',$wish);
        $this->assertDatabaseHas('wishes',[
            'name' => $wish['name'],
            'description' => $wish['description']
        ]);
    }

    /** @test */
    public function a_guest_cannot_create_a_wish() {
		$this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/wish',[]);
    }
}
