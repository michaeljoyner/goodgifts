<?php


namespace Tests\Unit\Products;


use App\Articles\Article;
use App\Products\Product;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_product_can_query_its_related_suggestions()
    {
        $product = factory(Product::class)->create();
        $article = factory(Article::class)->create();
        $article->attachProducts($product);

        $this->assertCount(1, Suggestion::all());
        $suggestion = Suggestion::first();

        $this->assertEquals($product->suggestions->first()->id, $suggestion->id);
    }
}