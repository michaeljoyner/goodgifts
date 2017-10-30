<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceListTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_all_products_can_be_retrieved()
    {
        $this->disableExceptionHandling();
        $products = factory(Product::class, 10)->create();

        $response = $this->json('GET', '/services/products');
        $response->assertStatus(200);

        $fetched_products = $response->decodeResponseJson();

        $this->assertCount(10, $fetched_products);

        $products->each(function($product) use ($fetched_products) {
           $this->assertContains($product->toJsonableArray(), $fetched_products);
        });
    }
}