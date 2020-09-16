<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Posttypes;
use Faker\Generator as Faker;

$factory->define(PostTypes::class, function (Faker $faker) {
    return [
        //
		'title' => 'static',
        'description' => $faker->text(100),
    ];
});
