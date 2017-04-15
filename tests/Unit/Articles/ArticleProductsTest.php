<?php


namespace Tests\Unit\Articles;


use App\Articles\Article;
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

        $this->assertContains($updatedHtml, $article->fresh()->body);
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

        $this->assertContains($this->getProductHtml($updatedProduct->toArray()), $article->fresh()->body);
        $this->assertNotContains('Â', $article->fresh()->body);


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

        $this->assertContains($this->getProductHtml($updatedProduct->toArray()), $article->fresh()->body);
        $this->assertNotContains('Â', $article->fresh()->body);
    }

    protected function getProductHtml($product)
    {
        $productHtmlTemplate = '<div class="amazon-product-card" data-amzn-id="%s"><p class="amazon-product-title">%s</p><div class="product-image-box"><a href="%s"><img src="%s" alt="%s"></a></div><a href="%s"><span class="vendor-name">amazon</span><span class="inner-price">%s</span></a></div>';

        return sprintf($productHtmlTemplate, $product['itemid'], $product['title'], $product['link'], $product['image'],
            $product['title'], $product['link'], $product['price']);
    }
}