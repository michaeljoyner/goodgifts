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
}