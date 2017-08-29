<?php


namespace Tests\Unit\Products;


use App\Articles\Article;
use App\Products\Product;
use App\Products\TaggingIssuesRepository;
use App\Suggestions\Suggestion;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TaggingIssuesRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->repo = new TaggingIssuesRepository;
    }

    /**
     *@test
     */
    public function it_can_find_all_products_not_belonging_to_an_article()
    {
        $article_products = factory(Product::class, 2)->create();
        $productC = factory(Product::class)->create();

        $article = factory(Article::class)->create();

        $article->attachProducts($article_products);

        $this->assertCount(1, $this->repo->orphanProducts());
        $this->assertContains($productC->id, $this->repo->orphanProducts()->pluck('id')->all());
    }

    /**
     *@test
     */
    public function it_can_find_all_products_that_lack_a_suggestion()
    {
        $unreasoned_suggestion = $this->makeSuggestionForProductAndArticle(
            factory(Product::class)->create(),
            factory(Article::class)->create(),
            null,
            null
        );

        $reasoned_suggestion = $this->makeSuggestionForProductAndArticle(
            factory(Product::class)->create(),
            factory(Article::class)->create(),
            'TEST WHAT',
            "TEST WHY"
        );

        $this->assertCount(1, $this->repo->unreasonedSuggestions());
        $this->assertEquals($unreasoned_suggestion->id, $this->repo->unreasonedSuggestions()->first()->id);
    }

    /**
     *@test
     */
    public function it_does_not_include_suggestions_with_null_articles_or_products()
    {
        $deleted_product = factory(Product::class)->create();
        $deleted_article = factory(Article::class)->create();
        $this->makeSuggestionForProductAndArticle(
            $deleted_product,
            factory(Article::class)->create(),
            null,
            null
        );
        $this->makeSuggestionForProductAndArticle(
            factory(Product::class)->create(),
            $deleted_article,
            null,
            null
        );
        $unreasoned_suggestion = $this->makeSuggestionForProductAndArticle(
            factory(Product::class)->create(),
            factory(Article::class)->create(),
            null,
            null
        );
        $deleted_product->delete();
        $deleted_article->delete();

        $this->assertCount(1, $this->repo->unreasonedSuggestions());
        $this->assertEquals($unreasoned_suggestion->id, $this->repo->unreasonedSuggestions()->first()->id);
    }

    /**
     *@test
     */
    public function it_can_query_all_products_that_lack_tags()
    {
        $tagged_product = factory(Product::class)->create();
        $tagged_product->setTags(['TEST TAG']);

        $untagged_product = factory(Product::class)->create();

        $this->assertCount(1, $this->repo->untaggedProducts());

        $this->assertEquals($untagged_product->id, $this->repo->untaggedProducts()->first()->id);
    }

    protected function makeSuggestionForProductAndArticle($product, $article, $what, $why)
    {
        $article->attachProducts($product);
        $suggestion = Suggestion::where('article_id', $article->id)->where('product_id', $product->id)->first();
        $suggestion->what = $what;
        $suggestion->why = $why;
        $suggestion->save();

        return $suggestion;
    }
}