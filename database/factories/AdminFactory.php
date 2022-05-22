<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
    	'name'  => $faker->name,
	    'email' => $faker->unique()->safeEmail,
	    'role' 	=> 'admin',
	    'password'  => bcrypt('12345678'),
    ];
});
