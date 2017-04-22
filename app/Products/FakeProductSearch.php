<?php


namespace App\Products;


use Faker\Factory;

class FakeProductSearch implements ProductSearch
{
    public function for($params)
    {
        return factory(Product::class, 5)->make();
    }
}