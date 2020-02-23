<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Wish;
use Faker\Generator as Faker;

$factory->define(Wish::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'name' => str_replace("'","",$faker->name),
        'description' => $faker->sentence(),
        'where_to_buy' => $faker->url(),
        'price' => rand(5,20),
        'desire' => rand(1,10),
        'is_url'=>0
    ];
});
