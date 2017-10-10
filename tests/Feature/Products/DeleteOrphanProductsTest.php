<?php


namespace Tests\Feature\Products;


use App\Articles\Article;
use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteOrphanProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function orphaned_products_can_be_deleted()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();
        $article_products = factory(Product::class, 3)->create();
        $article->attachProducts($article_products);

        $orphan_products = factory(Product::class, 3)->create();

        $this->assertCount(6, Product::all());

        $response = $this->asLoggedInUser()->json('DELETE', "/admin/orphan-products");
        $response->assertStatus(302);
        $response->assertRedirect('/admin/tags/issues');

        $remaining_products = Product::all();

        $this->assertCount(3, $remaining_products);

        $orphan_products->each(function($product) use ($remaining_products) {
            $this->assertNotContains($product->id, $remaining_products->pluck('id')->all());
        });

    }
}