<?php


namespace Tests\Unit\Articles;


use App\Products\Product;
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

        $this->assertContains($updatedHtml, $article->fresh()->body);
        $this->assertContains('ABC456',$article->fresh()->body);
        $this->assertContains('ABC789',$article->fresh()->body);

    }

    protected function getProductHtml($product)
    {
        $productHtmlTemplate = '<div class="amazon-product-card" data-amzn-id="%s"><p class="amazon-product-title">%s</p><div class="product-image-box"><img src="%s" alt="%s"></div><a href="%s">At Amazon for %s</a></div>';

        return sprintf($productHtmlTemplate, $product['itemid'], $product['title'], $product['image'],
            $product['title'], $product['link'], $product['price']);
    }
}