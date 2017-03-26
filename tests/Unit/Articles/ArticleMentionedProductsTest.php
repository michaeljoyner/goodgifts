<?php


namespace Tests\Unit\Articles;


use App\Articles\Article;
use App\Products\FakeLookup;
use App\Products\Lookup;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ArticleMentionedProductsTest extends TestCase
{
    use DatabaseMigrations, MakesArticlesWithProducts;

    /**
     *@test
     */
    public function an_article_can_retrieve_the_products_mentioned_in_the_body()
    {
        $products = $this->getTestProducts();
        $article = $this->makeArticleWithProducts($products);

        $results = $article->mentionedProducts();

        $this->assertCount(3, $results);

        foreach ($products as $product) {
            $this->assertContains($product, $results);
        }
    }

    /**
     *@test
     */
    public function an_article_can_sync_unstored_mentioned_products_with_database()
    {
        $this->app->bind(Lookup::class, function($app) {
            return new FakeLookup();
        });
        $products = $this->getTestProducts();
        $article = $this->makeArticleWithProducts($products);

        $article->syncMentionedProducts();

        $this->assertCount(3, $article->fresh()->products);
    }
}