<?php


namespace Tests\Unit\Products;


use App\Products\FakeUnavailableProductLookup;
use Tests\TestCase;

class FakeUnavailableProductLookupTest extends TestCase
{
    /**
     *@test
     */
    public function a_fake_unavailable_product_lookup_will_return_only_unavailable_products()
    {
        $lookup = new FakeUnavailableProductLookup();

        $results = $lookup->withId('test-1,test-2,test-3');
        $results->each(function($product) {
            $this->assertFalse(($product->available));
        });
    }
}