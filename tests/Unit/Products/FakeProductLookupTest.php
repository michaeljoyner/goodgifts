<?php


namespace Tests\Unit\Products;


use Tests\TestCase;

class FakeProductLookupTest extends TestCase
{
    /**
     *@test
     */
    public function it_returns_a_fake_product_on_lookup_by_url()
    {
        $lookup = new \App\Products\FakeLookup();

        $product = $lookup->withId('TEST_ID');

        $this->assertInstanceOf(\App\Products\Product::class, $product);
    }
}