<?php


namespace Tests\Unit\Products;


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
}