<?php


namespace Tests\Unit\Amazon;



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
        $lookupResult = new \App\Amazon\LookupResult($responseXML);
        $collection = $lookupResult->getProducts();

        $this->assertInstanceOf(Collection::class, $collection);

        $product = $collection->first();

        $this->assertEquals('$5.79', $product->price);
        $this->assertEquals('The Murder of Roger Ackroyd: A Hercule Poirot Mystery (Hercule Poirot Mysteries)', $product->title);
        $this->assertEquals('https://images-na.ssl-images-amazon.com/images/I/51jXImzFE2L.jpg', $product->image);
        $this->assertEquals('0062073567', $product->itemid);
        $this->assertContains('The Queen of Mystery has come to Harper Collins! Agatha Christie, the acknowledged mistress of suspense—creator of indomitable sleuth Miss Marple' , $product->description);
        $this->assertEquals('https://www.amazon.com/Murder-Roger-Ackroyd-Hercule-Mysteries/dp/0062073567%3FSubscriptionId%3DAKIAIYHMBBZCAVFTSEKQ%26tag%3Dgoodgiftsforg-20%26linkCode%3Dxm2%26camp%3D2025%26creative%3D165953%26creativeASIN%3D0062073567', $product->link);
    }
}