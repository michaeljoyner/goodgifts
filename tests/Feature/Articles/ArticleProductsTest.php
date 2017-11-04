<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use App\Products\FakeLookup;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ArticleProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function the_products_attached_to_a_given_article_can_be_fetched()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();
        $products = factory(Product::class, 2)->create();
        $article->products()->attach($products->pluck('id')->toArray());

        $response = $this->asLoggedInUser()->json('GET', '/admin/articles/' . $article->id . '/products');
        $response->assertStatus(200);
        $responseData = $response->decodeResponseJson();

        $this->assertCount(2, $responseData);
    }

    /**
     * @test
     */
    public function a_product_can_be_added_to_an_article()
    {
        $this->disableExceptionHandling();
        $this->app->bind(\App\Products\Lookup::class, function ($app) {
            return new FakeLookup();
        });
        $article = factory(Article::class)->create();
        $productUrl = 'https://amazon.com/a-test-product/dp/B00TEST123/go-get-me';

        $response = $this->asLoggedInUser()
            ->post('/admin/articles/' . $article->id . '/products', ['item_ids' => $productUrl]);
        $response->assertStatus(200);
        $reponseData = $response->decodeResponseJson();

        $this->assertDatabaseHas('products', ['itemid' => 'B00TEST123']);
        $this->assertCount(1, $article->products);
        $this->assertEquals('B00TEST123', $article->products->first()->itemid);

        $this->assertCount(1, $reponseData);
        $this->assertEquals('B00TEST123', $reponseData[0]['itemid']);
    }

    /**
     *@test
     */
    public function successfully_adding_a_product_responds_with_the_products_with_tags()
    {
        $this->disableExceptionHandling();
        $this->app->bind(\App\Products\Lookup::class, function ($app) {
            return new FakeLookup();
        });
        $article = factory(Article::class)->create();
        $productUrl = 'https://amazon.com/a-test-product/dp/B00TEST123/go-get-me';

        $response = $this->asLoggedInUser()
                         ->post('/admin/articles/' . $article->id . '/products', ['item_ids' => $productUrl]);
        $response->assertStatus(200);
        $reponseData = $response->decodeResponseJson();

        $this->assertArrayHasKey('tags', $reponseData[0]);
    }

    /**
     * @test
     */
    public function a_product_that_already_exists_in_the_database_does_not_need_to_be_looked_up()
    {
        $this->disableExceptionHandling();
        $lookup = $this->createMock(FakeLookup::class);
        $lookup->expects($this->never())->method('withId');
        $this->app->bind(\App\Products\Lookup::class, function ($app) use ($lookup) {
            return $lookup;
        });
        factory(Product::class)->create(['itemid' => 'B00TEST666']);

        $article = factory(Article::class)->create();
        $productUrl = 'https://amazon.com/a-test-product/dp/B00TEST666/go-get-me';

        $response = $this->asLoggedInUser()
            ->post('/admin/articles/' . $article->id . '/products', ['item_ids' => $productUrl]);
        $response->assertStatus(200);

        $this->assertCount(1, $article->products);
        $this->assertEquals('B00TEST666', $article->products->first()->itemid);
        $this->assertCount(1, Product::all());


    }

    /**
     * @test
     */
    public function a_product_can_be_removed_from_an_article()
    {
        $article = factory(Article::class)->create();
        $product = factory(Product::class)->create();
        $article->products()->attach($product->id);

        $response = $this->asLoggedInUser()->delete('/admin/articles/' . $article->id . '/products/' . $product->id);
        $response->assertStatus(200);

        $this->assertCount(0, $article->fresh()->products);
    }

    /**
     * @test
     */
    public function removing_a_product_that_is_only_attached_to_that_given_article_also_deletes_the_product()
    {
        $article = factory(Article::class)->create();
        $product = factory(Product::class)->create();
        $article->products()->attach($product->id);

        $response = $this->asLoggedInUser()->delete('/admin/articles/' . $article->id . '/products/' . $product->id);
        $response->assertStatus(200);

        $this->assertCount(0, $article->fresh()->products);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /**
     * @test
     */
    public function an_article_product_may_have_a_what_and_why()
    {
        $this->disableExceptionHandling();
        $article = factory(Article::class)->create();
        $product = factory(Product::class)->create();
        $article->products()->attach($product->id);

        $response = $this->asLoggedInUser()->json('POST',
            '/admin/articles/' . $article->id . '/products/' . $product->id . '/reasons',
            ['what' => 'This says what it is', 'why' => 'this says why it is a good idea']);
        $response->assertStatus(200);

        $this->assertDatabaseHas('article_product', [
            'article_id' => $article->id,
            'product_id' => $product->id,
            'what' => 'This says what it is',
            'why' => 'this says why it is a good idea'
        ]);
    }


}