<?php


namespace Tests\Feature\Articles;


use App\Articles\Article;
use App\Products\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ArticleProductsUpdateTest extends TestCase
{
    use DatabaseMigrations, MakesArticlesWithProducts;

    /**
     *@test
     */
    public function all_articles_body_products_can_be_updated_via_artisan_command()
    {
        $article1 = $this->makeArticleWithProducts($this->getTestProducts());
        $article2 = $this->makeArticleWithProducts($this->getAdditionalProducts());

        $product1 = factory(Product::class)->create(['itemid' =>'ABC123']);
        $product2 = factory(Product::class)->create(['itemid' =>'ABC456']);
        $product3 = factory(Product::class)->create(['itemid' =>'ABC789']);
        $product4 = factory(Product::class)->create(['itemid' =>'XXX123']);
        $product5 = factory(Product::class)->create(['itemid' =>'XXX456']);

        Artisan::call('article_products:update');

        $this->assertArticleContainsProduct($article1, $product1);
        $this->assertArticleContainsProduct($article1, $product2);
        $this->assertArticleContainsProduct($article1, $product3);
        $this->assertArticleContainsProduct($article2, $product4);
        $this->assertArticleContainsProduct($article2, $product5);

    }

    protected function assertArticleContainsProduct($article, $product)
    {
        $article = $article->fresh();
        $this->assertContains('<div class="amazon-product-card" data-amzn-id="' . $product->itemid . '">', $article->body);
        $this->assertContains('<p class="amazon-product-title">' . $product->title . '</p>', $article->body);
        $this->assertContains('<img src="' . $product->image . '" alt="' . $product->title . '">', $article->body);
        $this->assertContains('<a href="' . $product->link . '">At Amazon for ' . $product->price . '</a>', $article->body);
    }

    protected function getAdditionalProducts()
    {
        return [
            [
                'itemid' => 'XXX123',
                'title'  => 'Next Example One',
                'link'   => 'https://example.com/1',
                'image'  => 'test-image-link-1',
                'price'  => 'test-price-1'
            ],
            [
                'itemid' => 'XXX456',
                'title'  => 'Example Two',
                'link'   => 'https://example.com/2',
                'image'  => 'test-image-link-2',
                'price'  => 'test-price-2'
            ]
        ];
    }
}