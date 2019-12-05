<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all()->each(function($user,$key) {
            // for each user in our database

            // special condition for first user
            if ($user->id ==1) {
                // create 3 purchased wishes
                factory('App\Wish',3)->create([
                    'user_id'=>$user->id,
                    'purchased_by'=>2,
                    'purchased_at'=>Carbon::now()
                ]);

            } else if ($user->id ==2) {
                // dont create any wishes for the second user

            } else {
                // for every other user
                
                // create 2 unpurchased wishes
                factory('App\Wish',2)->create([
                    'user_id'=>$user->id
                ]);
                // and 1 purchased wish
                factory('App\Wish')->create([
                    'user_id'=>$user->id,
                    'purchased_by'=>1,
                    'purchased_at'=>Carbon::now()
                ]);
            }
        });
    }
}
