<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_may_be_deleted()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->delete('/admin/products/' . $product->id);
        $response->assertStatus(302);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}