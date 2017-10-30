<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_may_be_featured()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create(['featured' => false]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/featured-products", [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'       => $product->id,
            'featured' => true
        ]);
    }

    /**
     * @test
     */
    public function the_product_id_is_required()
    {
        $response = $this->asLoggedInUser()->json('POST', "/admin/featured-products", [
            'product_id' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function the_product_id_must_exist_in_the_products_table()
    {
        $this->assertCount(0, Product::all());
        $response = $this->asLoggedInUser()->json('POST', "/admin/featured-products", [
            'product_id' => 3
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function a_product_can_be_demoted_from_featured_status()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create(['featured' => true]);

        $response = $this->asLoggedInUser()->json('DELETE', "/admin/featured-products/{$product->id}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'       => $product->id,
            'featured' => false
        ]);
    }

    /**
     *@test
     */
    public function a_list_of_featured_products_can_be_retrieved()
    {
        $this->disableExceptionHandling();
        $non_featured = factory(Product::class, 2)->create(['featured' => false]);
        $featured_products = factory(Product::class, 3)->create(['featured' => true]);
        $response = $this->asLoggedInUser()->json('GET', "/admin/services/featured-products");
        $response->assertStatus(200);

        $fetched_products = $response->decodeResponseJson();

        $this->assertCount(3, $fetched_products);

        $featured_products->each(function($product) use ($fetched_products) {
            $this->assertContains($product->toJsonableArray(), $fetched_products);
        });
    }
}