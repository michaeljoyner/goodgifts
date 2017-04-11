<?php


namespace Tests\Unit\Articles;



use App\Articles\Article;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ArticleUpdateTest extends TestCase
{
    use DatabaseMigrations, MakesArticlesWithProducts;

    /**
     *@test
     */
    public function an_article_update_issue_is_created_if_exception_is_thrown_in_update_body_with_product_method()
    {
        //using a non eloquent product will cause exception to be thrown
        $product = new class {
            public $itemid = 'test1';
            public $id = 1;

            public function toArray() {
                throw new \Exception('This object causes issues');
            }
        };
        $article = factory(Article::class)->create();

        try {
            $article->updateBodyWithProduct($product);
        } catch(\Exception $e) {

        }

        $this->assertCount(1, \App\Issues\ArticleUpdateIssue::all());
        $issue = \App\Issues\ArticleUpdateIssue::first();
        $this->assertEquals($article->id, $issue->article_id);
        $this->assertEquals($product->id, $issue->product_id);
    }

    /**
     *@test
     */
    public function updating_an_article_with_the_same_products_should_not_change_the_body()
    {
        $products = factory(Product::class, 10)->create();
        $article = $this->makeArticleWithProducts($products->map->toArray());

        $products->each(function($product) use ($article) {
            $article->updateBodyWithProduct($product);
        });
        $secondBody = $article->fresh()->body;
        $article = $article->fresh();
        $products->each(function($product) use ($article) {
            $article->updateBodyWithProduct($product);
        });
        $thirdBody = $article->fresh()->body;
        $this->assertEquals($secondBody, $thirdBody);
    }
}