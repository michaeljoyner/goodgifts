<?php


namespace Tests\Unit\Amazon;



use App\Amazon\LookupResult;
use Illuminate\Support\Collection;
use Tests\TestCase;

class LookupResultTest extends TestCase
{
    /**
     *@test
     */
    public function it_returns_a_collection_of_products_from_a_successful_lookup()
    {
        $responseXML = file_get_contents('tests/fixtures/amazon_lookup_success.xml');
        $lookupResult = new LookupResult($responseXML);
        $collection = $lookupResult->getProducts();

        $this->assertInstanceOf(Collection::class, $collection);

        $product = $collection->first();

        $this->assertEquals('$5.79', $product->price);
        $this->assertEquals('The Murder of Roger Ackroyd: A Hercule Poirot Mystery (Hercule Poirot Mysteries)', $product->title);
        $this->assertEquals('https://images-na.ssl-images-amazon.com/images/I/51jXImzFE2L.jpg', $product->image);
        $this->assertEquals('0062073567', $product->itemid);
        $this->assertEquals('https://www.amazon.com/Murder-Roger-Ackroyd-Hercule-Mysteries/dp/0062073567%3FSubscriptionId%3DAKIAIYHMBBZCAVFTSEKQ%26tag%3Dgoodgiftsforg-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D0062073567', $product->link);
    }

    /**
     *@test
     */
    public function a_lookup_of_an_unavailable_product_returns_a_product_marked_as_unavailable()
    {
        $responseXML = file_get_contents('tests/fixtures/lookup_unavailable.xml');
        $lookupResult = new LookupResult($responseXML);
        $collection = $lookupResult->getProducts();

        $this->assertInstanceOf(Collection::class, $collection);

        $product = $collection->first();
        $this->assertFalse($product->available);
    }

    /**
     *@test
     */
    public function a_product_with_a_product_offer_listing_is_available()
    {
        $responseXML = file_get_contents('tests/fixtures/amazon_lookup_success.xml');
        $lookupResult = new LookupResult($responseXML);
        $collection = $lookupResult->getProducts();

        $this->assertInstanceOf(Collection::class, $collection);

        $product = $collection->first();
        $this->assertTrue($product->available);
    }

    /**
     *@test
     */
    public function a_lookup_for_a_product_with_a_sale_price_is_returned_with_the_sale_price()
    {
        $responseXML = file_get_contents('tests/fixtures/lookup_deal_price.xml');
        $lookupResult = new LookupResult($responseXML);
        $collection = $lookupResult->getProducts();

        $this->assertInstanceOf(Collection::class, $collection);

        $product = $collection->first();
        $this->assertTrue($product->available);
        $this->assertContains('$17.87', $product->price);
    }

    /**
     *@test
     */
    public function a_lookup_with_a_lower_offer_price_than_list_price_returns_product_with_offer_price()
    {
        $responseXML = file_get_contents('tests/fixtures/lookup_has_deal.xml');
        $lookupResult = new LookupResult($responseXML);
        $collection = $lookupResult->getProducts();

        $this->assertInstanceOf(Collection::class, $collection);

        $product = $collection->first();
        $this->assertTrue($product->available);
        $this->assertContains('$19.52', $product->price);
    }

    /**
     *@test
     */
    public function a_lookup_result_will_use_the_offer_price_even_if_more_expensive_if_it_exists()
    {
        $responseXML = file_get_contents('tests/fixtures/lookup_nintendo_strange_price.xml');
        $lookupResult = new LookupResult($responseXML);
        $collection = $lookupResult->getProducts();

        $this->assertInstanceOf(Collection::class, $collection);

        $product = $collection->first();
        $this->assertTrue($product->available);
        $this->assertContains('$169.70', $product->price);
    }
}