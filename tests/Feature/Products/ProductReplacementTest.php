<?php


namespace Tests\Feature\Products;


use App\Issues\Issue;
use App\Products\FakeLookup;
use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ProductReplacementTest extends TestCase
{
    use RefreshDatabase, MakesArticlesWithProducts;

    public function setUp()
    {
        Notification::fake();

        parent::setUp();

        $this->app->bind(Lookup::class, function() {
            return new FakeLookup();
        });
    }

    /**
     *@test
     */
    public function a_product_can_be_updated_to_use_different_amazon_id()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create([
            'itemid'      => '0000000000',
            'title'       => 'Original Product',
            'description' => 'Original Description',
            'link'        => 'original-link',
            'image'       => 'original-image',
            'price'       => '$111'
        ]);

        $response = $this->asLoggedInUser()->json('POST', '/admin/products/' . $product->id, [
            'amazon_id' => 'XXXXXXXXXX'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Fake title',
            'link' => 'Fake link',
            'description' => 'Fake description',
            'image' => 'Fake image',
            'price' => 'Fake price',
            'itemid' => 'XXXXXXXXXX',
            'available' => true
        ]);
    }

    /**
     *@test
     */
    public function replacing_a_product_also_updates_an_articles_it_may_be_included_in()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create([
            'itemid'      => '0000000000',
            'title'       => 'Original Product',
            'description' => 'Original Description',
            'link'        => 'original-link',
            'image'       => 'original-image',
            'price'       => '$111'
        ]);

        $article = $this->makeArticleWithProducts([$product->toArray()]);
        $article->attachProducts(collect($product));
        $this->assertContains('Original Product', $article->body);

        $response = $this->asLoggedInUser()->json('POST', '/admin/products/' . $product->id, [
            'amazon_id' => 'XXXXXXXXXX'
        ]);
        $response->assertStatus(200);

        $this->assertContains('Fake title', $article->fresh()->body);
        $this->assertContains('Fake link', $article->fresh()->body);
        $this->assertContains('Fake image', $article->fresh()->body);
    }

    /**
     *@test
     */
    public function replacing_a_product_successfully_returns_the_updated_product_info()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create([
            'itemid'      => '0000000000',
            'title'       => 'Original Product',
            'description' => 'Original Description',
            'link'        => 'original-link',
            'image'       => 'original-image',
            'price'       => '$111'
        ]);

        $article = $this->makeArticleWithProducts([$product->toArray()]);
        $article->attachProducts(collect($product));
        $this->assertContains('Original Product', $article->body);

        $response = $this->asLoggedInUser()->json('POST', '/admin/products/' . $product->id, [
            'amazon_id' => 'XXXXXXXXXX'
        ]);
        $response->assertStatus(200);
        $response_data = $response->decodeResponseJson();
        $this->assertEquals($product->id, $response_data['id']);
        $this->assertEquals('XXXXXXXXXX', $response_data['itemid']);
        $this->assertEquals('Fake title', $response_data['title']);
        $this->assertEquals('Fake image', $response_data['image']);
        $this->assertEquals('Fake price', $response_data['price']);
        $this->assertEquals('Fake link', $response_data['link']);
    }

    /**
     *@test
     */
    public function replacing_a_product_successfully_will_remove_any_unavailable_product_issues_for_the_product()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create([
            'itemid'      => '0000000000',
        ]);

        $issue = Issue::createUnavailableProductIssue('Product not available', ['product_id' => $product->id]);

        $response = $this->asLoggedInUser()->json('POST', '/admin/products/' . $product->id, [
            'amazon_id' => 'XXXXXXXXXX'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'itemid' => 'XXXXXXXXXX',
        ]);

        $this->assertDatabaseMissing('issues', ['id' => $issue->id]);
    }
}