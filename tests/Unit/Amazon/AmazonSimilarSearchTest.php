<?php


namespace Tests\Unit\Amazon;


use App\Amazon\AmazonSimilarSearch;
use App\Products\Product;
use Tests\TestCase;

class AmazonSimilarSearchTest extends TestCase
{
    /**
     *@test
     *@group integration
     */
    public function similar_products_can_be_fetched_from_amazon()
    {
        $search = new AmazonSimilarSearch();
        //amazon asin id for agatha christie's "And then there were none"
        $itemid = '0062073486';

        $products = $search->for($itemid);

        $this->assertGreaterThan(1, $products->count());
        $this->assertLessThan(11, $products->count());

        $products->each(function($product) {
            $this->assertInstanceOf(Product::class, $product);
        });
    }
}