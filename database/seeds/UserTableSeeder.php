<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User',10)->create();
        factory('App\User')->create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>Hash::make('test')
        ]);
    }
}
