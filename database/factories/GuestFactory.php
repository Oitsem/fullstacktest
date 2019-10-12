<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Guest;
use Faker\Generator as Faker;

$factory->define(Guest::class, function (Faker $faker) {
    return [
        'user_id'       => 1,
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email' => $faker->safeEmail,
        'phone_number'  => $faker->e164PhoneNumber,
        'gender'        => rand(0, 1),
        'address'       => $faker->address
    ];
});
