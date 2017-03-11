<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    /**
     * @test
     */
    public function a_successful_product_search_returns_a_collection_of_products()
    {
        $this->app->bind(\App\Products\ProductSearch::class, function () {
            return new \App\Products\FakeProductSearch;
        });

        $response = $this->get('/gifts/?place=outdoors&hobby=hiking');
        $response->assertStatus(200)
            ->assertJsonStructure([
                [
                    'name',
                    'image_src',
                    'description',
                    'rating',
                    'link'
                ]
            ]);

        $this->assertTrue(count($response->decodeResponseJson()) > 0);
    }
}