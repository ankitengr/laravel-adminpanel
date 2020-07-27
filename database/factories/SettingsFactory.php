<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Settings;
use Faker\Generator as Faker;

$factory->define(Settings::class, function (Faker $faker) {
    return [
        //
		'option_name' => 'version',
        'option_value' => '1.0',
        'allow_edit' => 0,
        'status' => 1,
    ];
});
