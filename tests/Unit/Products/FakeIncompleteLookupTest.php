<?php


namespace Tests\Unit\Products;


use Tests\TestCase;

class FakeIncompleteLookupTest extends TestCase
{
    /**
     *@test
     */
    public function it_returns_an_incomplete_set_of_products()
    {
        $lookup = new \App\Products\FakeIncompleteLookup();

        $products = $lookup->withId('teset-1, test-2, test-3');

        $this->assertTrue($products->count() > 0);
        $this->assertTrue($products->count() < 3);
    }
}