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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Articles\Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'body' => $faker->paragraphs(5, true),
        'published' => false,
        'published_on' => null
    ];
});

$factory->define(App\Products\Product::class, function (Faker\Generator $faker) {
    return [
        'itemid' => 'B01TEST000',
        'title' => 'Factory Product',
        'description' => $faker->paragraph,
        'link' => $faker->url,
        'image' => 'factory-url',
        'price' => '$DUMMY'
    ];
});
