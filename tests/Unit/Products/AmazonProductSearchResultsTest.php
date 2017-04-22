<?php


use Tests\TestCase;

class AmazonProductSearchResultsTest extends TestCase
{
    /**
     * @test
     */
    public function the_results_can_be_parsed_into_a_collection_of_products()
    {
        $xml = file_get_contents('tests/fixtures/amazn_item_search_success.xml');

        $searchResults = new \App\Products\AmazonSearchResults($xml);
        $products = $searchResults->getProducts();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $products);
        $this->assertInstanceOf(\App\Products\Product::class, $products->first());
        $this->assertEquals('And Then There Were None', $products->first()->title);
        $this->assertEquals('https://www.amazon.com/Then-There-Were-None/dp/0062073486%3FSubscriptionId%3DAKIAIYHMBBZCAVFTSEKQ%26tag%3Dgoodgiftsforg-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D0062073486',
            trim($products->first()->link));
        $this->assertEquals('$6.00', $products->first()->price);
        $this->assertEquals('https://images-na.ssl-images-amazon.com/images/I/51ToGkqvjAL.jpg',
            $products->first()->image);
        $this->assertEquals('0062073486', $products->first()->itemid);
    }
}