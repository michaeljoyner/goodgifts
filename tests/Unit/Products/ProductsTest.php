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
     * @test
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

    /**
     * @test
     */
    public function a_product_can_be_updated_to_be_replaced_with_another_products_details()
    {
        $productA = factory(Product::class)->create([
            'itemid'      => 'AAAAAAAAAA',
            'title'       => 'A Product',
            'description' => 'A Description',
            'link'        => 'A-link',
            'image'       => 'A-image',
            'price'       => '$AAA'
        ]);
        $productB = factory(Product::class)->create([
            'itemid'      => 'BBBBBBBBBB',
            'title'       => 'B Product',
            'description' => 'B Description',
            'link'        => 'B-link',
            'image'       => 'B-image',
            'price'       => '$BBB',
            'available'   => true
        ]);

        $productA->replaceWith($productB);

        $this->assertEquals('BBBBBBBBBB', $productA->fresh()->itemid);
        $this->assertEquals('B Product', $productA->fresh()->title);
        $this->assertEquals('B Description', $productA->fresh()->description);
        $this->assertEquals('B-link', $productA->fresh()->link);
        $this->assertEquals('B-image', $productA->fresh()->image);
        $this->assertEquals('$BBB', $productA->fresh()->price);
    }

    /**
     * @test
     */
    public function a_product_can_be_presented_as_a_jsonable_array()
    {
        $product = factory(Product::class)->create([
            'itemid' => 'AAAAAAAAAA',
            'title'  => 'A Product',
            'link'   => 'A-link',
            'image'  => 'A-image',
            'price'  => '$888'
        ]);

        $product->setTags(['tagA', 'tagB', 'tagC']);

        $article = factory(Article::class)->create();
        $suggestion = factory(Suggestion::class)->create([
            'article_id' => $article->id,
            'product_id' => $product->id,
            'what'       => 'Product what',
            'why'        => 'Suggestion why'
        ]);

        $this->assertEquals([
            'id'          => $product->id,
            'itemid'      => 'AAAAAAAAAA',
            'title'       => 'A Product',
            'link'        => 'A-link',
            'image'       => 'A-image',
            'price'       => '$888',
            'price_cents' => 88800,
            'tags'        => ['tagA', 'tagB', 'tagC'],
            'suggestions' => [
                ['article_id' => $article->id, 'what' => 'Product what', 'why' => 'Suggestion why']
            ]
        ], $product->toJsonableArray());
    }

    /**
     * @test
     */
    public function a_product_can_give_its_numeric_price()
    {
        $product = factory(Product::class)->create(['price' => '$12.34']);

        $this->assertEquals(1234, $product->priceCents());
    }

    /**
     * @test
     */
    public function a_product_with_a_non_numeric_price_has_a_null_price_cents_value()
    {
        $product = factory(Product::class)->create(['price' => 'NOT-A-PRICE']);

        $this->assertNull($product->priceCents());
    }

    /**
     *@test
     */
    public function it_can_read_prices_with_comma_thousand_separators()
    {
        $product = factory(Product::class)->create(['price' => '$1,234.00']);

        $this->assertEquals(123400, $product->priceCents());
    }

    /**
     *@test
     */
    public function a_product_may_be_featured()
    {
        $product = factory(Product::class)->create(['featured' => false]);

        $product->feature();

        $this->assertTrue($product->fresh()->featured);
    }

    /**
     *@test
     */
    public function a_product_can_be_demoted()
    {
        $product = factory(Product::class)->create(['featured' => true]);

        $product->demote();

        $this->assertFalse($product->fresh()->featured);
    }


}