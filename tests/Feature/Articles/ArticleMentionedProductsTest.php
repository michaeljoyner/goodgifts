<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use App\Products\FakeLookup;
use App\Products\Lookup;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ArticleMentionedProductsTest extends TestCase
{
    use DatabaseMigrations, MakesArticlesWithProducts;

    /**
     * @test
     */
    public function the_products_mentioned_in_a_given_article_can_be_fetched()
    {
        $products = $this->getTestProducts();

        $article = $this->makeArticleWithProducts($products);

        $response = $this->asLoggedInUser()->json('GET', '/admin/services/articles/' . $article->id . '/products');
        $response->assertStatus(200);
        $results = $response->decodeResponseJson();

        foreach ($products as $product) {
            $this->assertContains($product, $results);
        }
    }

    /**
     *@test
     */
    public function an_articles_mentioned_products_can_be_synced_back_into_the_database()
    {
        $this->app->bind(Lookup::class, function($app) {
            return new FakeLookup();
        });

        $products = $this->getTestProducts();
        $article = $this->makeArticleWithProducts($products);

        $this->assertCount(0, $article->products);

        Artisan::call('article_products:sync');

        $this->assertCount(3, $article->fresh()->products);
        foreach($products as $product) {
            $this->assertDatabaseHas('products', ['itemid' => $product['itemid']]);
        }
    }


}