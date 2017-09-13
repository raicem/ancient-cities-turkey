<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Ruin::class, function (Faker\Generator $faker) {
    $name = $faker->word;
    return [
        'name'        => $name,
        'slug'        => str_slug($name),
        'latitude'    => $faker->latitude(36, 42),
        'longitude'   => $faker->longitude(26, 44),
        'information' => $faker->sentence,
        'image' => $faker->imageUrl(400, 150)
    ];
});

$factory->define(App\Link::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->word,
        'url' => $faker->url,
        'language' => $faker->randomElement(['tr', 'en'])
    ];
});

$factory->define(App\Feedback::class, function (Faker\Generator $faker) {
    $ruin = factory(App\Ruin::class)->create();
    return [
        'ruin_id' => $ruin->id,
        'ruin'    => $ruin->slug,
        'body' => $faker->paragraph
    ];
});
