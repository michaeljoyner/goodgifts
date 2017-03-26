<?php


namespace Tests\Unit\Products;


use App\Products\FakeLookup;
use Illuminate\Support\Collection;
use Tests\TestCase;

class FakeProductLookupTest extends TestCase
{
    /**
     *@test
     */
    public function it_returns_an_collection_of_fake_products_on_lookup_by_url()
    {
        $lookup = new \App\Products\FakeLookup();

        $products = $lookup->withId('TEST_ID');

        $this->assertInstanceOf(Collection::class, $products);
        $this->assertInstanceOf(\App\Products\Product::class, $products->first());
    }

    /**
     *@test
     */
    public function it_will_correctly_parse_item_ids_from_urls()
    {
        $url = 'http://amazon.com/test-url/dp/B00TEST123/query-info';
        $lookup = new FakeLookup();

        $products = $lookup->withId($url);
        $this->assertEquals('B00TEST123', $products->first()->itemid);
    }
}