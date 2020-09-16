<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Posts;
use Faker\Generator as Faker;

$factory->define(Posts::class, function (Faker $faker) {
    return [
        //
		'title' => $faker->text(),
		'post_types_id' => 1,
        'description' => $faker->text(),
		'image' => '',
		'publish_up' => '0000-00-00 00:00:00',
    ];
});
