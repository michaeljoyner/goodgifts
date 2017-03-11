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
            $products->first()->link);
        $this->assertEquals(html_entity_decode('&lt;p&gt;One of the most famous and beloved mysteries from The Queen of Suspense—Agatha
                        Christie—now a Lifetime TV movie.&lt;/p&gt;&lt;p&gt;"Ten . . ."&lt;br /&gt;Ten strangers are
                        lured to an isolated island mansion off the Devon coast by a mysterious "U. N. Owen."&lt;/p&gt;&lt;p&gt;"Nine
                        . . ."&lt;br /&gt;At dinner a recorded message accuses each of them in turn of having a guilty
                        secret, and by the end of the night one of the guests is dead.&lt;/p&gt;&lt;p&gt;"Eight . . ."&lt;br
                        /&gt;Stranded by a violent storm, and haunted by a nursery rhyme counting down one by one . . .
                        as one by one . . . they begin to die.&lt;/p&gt;&lt;p&gt;"Seven . . ."&lt;br /&gt;Which among
                        them is the killer and will any of them survive?&lt;/p&gt;'), $products->first()->description);
        $this->assertEquals('$7.99', $products->first()->price);
        $this->assertEquals('https://images-na.ssl-images-amazon.com/images/I/51ToGkqvjAL.jpg',
            $products->first()->image);
        $this->assertEquals('0062073486', $products->first()->itemid);
    }
}