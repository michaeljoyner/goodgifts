<?php


namespace App\Products;


use Faker\Factory;

class FakeProductSearch implements ProductSearch
{
    public function for($params)
    {
        $faker = Factory::create();

        return collect(range(1,5))->map(function($index) use ($faker) {
            return [
                'name' => $faker->name,
                'image_src' => $faker->imageUrl(),
                'description' => $faker->paragraph,
                'rating' => $faker->randomFloat(1, 1, 5),
                'link' => 'https://amazon.com/' . $faker->word
            ];
        });
    }
}