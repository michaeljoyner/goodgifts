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

$factory->define(App\Articles\Article::class, function (Faker\Generator $faker) {
    return [
        'title'        => $faker->sentence,
        'description'  => $faker->paragraph,
        'body'         => $faker->paragraphs(5, true),
        'published'    => false,
        'published_on' => null
    ];
});

$factory->define(App\Products\Product::class, function (Faker\Generator $faker) {
    return [
        'itemid'      => 'B01TEST' . $faker->numberBetween(100, 999),
        'title'       => 'Factory Product',
        'description' => $faker->paragraph,
        'link'        => $faker->url,
        'image'       => 'factory-url',
        'price'       => '$DUMMY'
    ];
});

$factory->define(App\Interests\Interest::class, function (Faker\Generator $faker) {
    return [
        'interest' => $faker->word
    ];
});

$factory->define(App\Recommendations\Request::class, function (Faker\Generator $faker) {
    return [
        'email'     => $faker->email,
        'birthday'  => \Carbon\Carbon::now()->addMonths(5)->format('m-d'),
        'recipient' => $faker->name,
        'sender'    => $faker->name,
        'budget'    => $faker->randomElement(['low', 'mid', 'high']),
        'interests' => $faker->words(3, true),
        'age_group' => $faker->randomElement(['young', 'mid', 'mature']),
    ];
});

$factory->define(App\Products\SuitedProduct::class, function (Faker\Generator $faker) {
    return [
        'article_id' => function () {
            return factory(\App\Articles\Article::class)->create()->id;
        },
        'product_id' => function () {
            return factory(\App\Products\Product::class)->create()->id;
        },
        'what'       => $faker->sentence,
        'why'        => $faker->sentence
    ];
});

$factory->define(App\Tags\Tag::class, function (Faker\Generator $faker) {
    return [
        'tag' => $faker->word
    ];
});