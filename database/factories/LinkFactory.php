<?php

use Faker\Generator as Faker;
use App\Models\Link;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Link::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'link' => $faker->url,
    ];
});
