<?php


namespace Tests\Feature;


use Illuminate\Support\Collection;
use Tests\TestCase;

class AmazonProductSearchTest extends TestCase
{
    /**
     *@test
     * @group integration
     */
    public function an_amazon_product_search_can_return_results()
    {
        $this->app->bind(\App\Products\ProductSearch::class, function () {
            return new \App\Products\AmazonProductSearch;
        });



        $search = $this->app->make(\App\Products\ProductSearch::class);

        $results = $search->for([
            'Author' => 'Agatha Christie',
            'ResponseGroup' => 'Images,ItemAttributes,Large',
            'SearchIndex' => 'Books',
            'Sort' => 'salesrank',
        ]);

//        dd($results);

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertInstanceOf(\App\Products\Product::class, $results->first());
        $this->assertTrue(true);

    }
}