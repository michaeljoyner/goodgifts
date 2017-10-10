<?php


namespace Tests\Unit\Articles;


use App\Articles\Article;
use App\Products\Product;
use App\Products\ProductHtml;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ArticleProductsTest extends TestCase
{
    use DatabaseMigrations, MakesArticlesWithProducts;

    /**
     *@test
     */
    public function a_product_in_an_article_body_may_be_updated()
    {
        $article = $this->makeArticleWithProducts($this->getTestProducts());

        $updatedProduct = factory(Product::class)->create([
            'itemid' => 'ABC123',
            'title' => 'Totally updated title',
            'price' => 'UPDATED-PRICE',
            'image' => 'new-image',
            'link' => 'updated-link'
        ]);

        $article->updateBodyWithProduct($updatedProduct);

        $updatedHtml = $this->getProductHtml($updatedProduct->toArray());
        $fresh_body = str_replace(PHP_EOL, '', $article->fresh()->body);

        $this->assertContains(ProductHtml::innerFor($updatedProduct->toArray()), $fresh_body);
        $this->assertContains('ABC456',$fresh_body);
        $this->assertContains('ABC789',$fresh_body);

    }

    /**
     *@test
     */
    public function an_article_with_a_numeric_first_itemid_can_be_properly_updated()
    {
        $product = [[
            'itemid' => '158008334X',
            'title' => 'The title',
            'price' => 'The price',
            'image' => 'image',
            'link' => 'link'
        ]];

        $article = $this->makeArticleWithProducts($product);

        $updatedProduct = factory(Product::class)->create([
            'itemid' => '158008334X',
            'title' => 'Totally updated title',
            'price' => 'UPDATED-PRICE',
            'image' => 'new-image',
            'link' => 'updated-link'
        ]);

        $article->updateBodyWithProduct($updatedProduct);

        $updatedHtml = $this->getProductHtml($updatedProduct->toArray());
        $fresh_body = str_replace(PHP_EOL, '', $article->fresh()->body);

        $this->assertContains($updatedHtml, $fresh_body);
    }
    
    /**
     *@test
     */
        public function an_article_with_non_breaking_spaces_is_properly_updated()
    {
        $product = [
            'itemid' => '158008334X',
            'title' => 'The title',
            'price' => 'The price',
            'image' => 'image',
            'link' => 'link'
        ];
        $articleBody = $this->getProductHtml($product);
        $articleBody .= '<p>&nbsp;</p>';
        $articleBody .= $this->getProductHtml($product);

        $article = factory(Article::class)->create(['body' => $articleBody]);
        $updatedProduct = factory(Product::class)->create([
            'itemid' => '158008334X',
            'title' => 'Totally updated title',
            'price' => 'UPDATED-PRICE',
            'image' => 'new-image',
            'link' => 'updated-link'
        ]);

        $article->updateBodyWithProduct($updatedProduct);
        $fresh_body = str_replace(PHP_EOL, '', $article->fresh()->body);

        $this->assertContains($this->getProductHtml($updatedProduct->toArray()), $fresh_body);
        $this->assertNotContains('Â', $fresh_body);


    }

    /**
     *@test
     */
    public function a_general_article_body_does_not_have_issues_when_updated()
    {
        $updatedProduct = factory(Product::class)->create([
            'itemid' => 'B01LWIURV8',
            'title' => 'Totally updated title',
            'price' => 'UPDATED-PRICE',
            'image' => 'new-image',
            'link' => 'updated-link'
        ]);
        $articleBody = file_get_contents('tests/fixtures/article_example_body.html');
        $article = factory(Article::class)->create(['body' => $articleBody]);

        $article->updateBodyWithProduct($updatedProduct);
        $fresh_body = str_replace(PHP_EOL, '', $article->fresh()->body);

        $this->assertContains($this->getProductHtml($updatedProduct->toArray()), $fresh_body);
        $this->assertNotContains('Â', $fresh_body);
    }

    /**
     *@test
     */
    public function products_can_be_attached_to_an_article()
    {
        $article = factory(Article::class)->create();
        $products = factory(Product::class, 2)->create();

        $article->attachProducts($products);


        $this->assertContains($products->first()->id, $article->fresh()->products->pluck('id')->toArray());
        $this->assertContains($products->last()->id, $article->fresh()->products->pluck('id')->toArray());
    }

    /**
     *@test
     */
    public function products_can_be_attached_to_an_article_by_id()
    {
        $article = factory(Article::class)->create();
        $products = factory(Product::class, 2)->create();

        $article->attachProducts($products->pluck('id')->toArray());

        $this->assertContains($products->first()->id, $article->fresh()->products->pluck('id')->toArray());
        $this->assertContains($products->last()->id, $article->fresh()->products->pluck('id')->toArray());
    }

    /**
     *@test
     */
    public function a_single_product_can_be_attached_to_an_article()
    {
        $article = factory(Article::class)->create();
        $product = factory(Product::class)->create();

        $article->attachProducts($product);

        $this->assertContains($product->id, $article->fresh()->products->pluck('id')->toArray());
    }

    /**
     *@test
     */
    public function products_can_be_detached_from_an_article()
    {
        $article = factory(Article::class)->create();
        $products = factory(Product::class, 2)->create();

        $article->attachProducts($products);

        $article->fresh()->detachProducts($products);

        $this->assertNotContains($products->first()->id, $article->fresh()->products->pluck('id')->toArray());
        $this->assertNotContains($products->last()->id, $article->fresh()->products->pluck('id')->toArray());
    }

    protected function getProductHtml($product)
    {
        return ProductHtml::for($product);
    }
}