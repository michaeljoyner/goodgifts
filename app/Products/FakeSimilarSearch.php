<?php


namespace App\Products;


class FakeSimilarSearch implements SimilarSearch
{

    public function for ($itemid)
    {
        return factory(Product::class, 10)->make(['available' => true]);
    }
}