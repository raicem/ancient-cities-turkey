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
        'name_tr'     => $faker->word,
        'slug'        => str_slug($name),
        'latitude'    => $faker->latitude(36, 42),
        'longitude'   => $faker->longitude(26, 44),
        'information' => $faker->sentence,
        'information_tr' => $faker->sentence,
        'official_site' => $faker->boolean,
        'tripadvisor' => $faker->url,
        'foursquare' => $faker->url,
        'official_site_tr' => $faker->url,
        'official_site_en' => $faker->url,
        'city_id' => factory(\App\City::class)->create()->id,
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

$factory->define(\App\City::class, function (Faker\Generator $faker) {
   return [
       'name' => $faker->city,
       'slug' => $faker->slug,
       'order' => $faker->numberBetween(1, 50),
   ];
});
