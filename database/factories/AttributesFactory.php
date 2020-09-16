<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attributes;
use Faker\Generator as Faker;

$factory->define(Attributes::class, function (Faker $faker) {
     return [
        'slug' => $faker->slug,
        'type' => $faker->randomElement(['boolean', 'datetime', 'integer', 'text', 'varchar']),
        'name' => $faker->name,
        //'entities' => $faker->randomElement(['App\Models\Company', 'App\Models\Product', 'App\Models\User']),
    ];
});
