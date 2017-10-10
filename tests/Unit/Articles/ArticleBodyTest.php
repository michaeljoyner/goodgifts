<?php


namespace Tests\Unit\Articles;


use App\Articles\ArticleBody;
use App\Products\Product;
use App\Products\ProductHtml;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\MakesArticlesWithProducts;
use Tests\TestCase;

class ArticleBodyTest extends TestCase
{
    use RefreshDatabase, MakesArticlesWithProducts;

    /**
     * @test
     */
    public function it_can_replace_text_links_of_an_old_product_with_a_new_products_link()
    {
        $linkA = 'https://www.amazon.com/JBL-Splash-Portable-Bluetooth-Speaker/dp/AAAAAAAAAA?psc=1&SubscriptionId=AKIAIYHMBBZCAVFTSEKQ&tag=goodgifts0c-20&linkCode=xm2&camp=2025&creative=165953&creativeASIN=B0145EVLMM';
        $linkB = 'https://www.amazon.com/JBL-Splash-Portable-Bluetooth-Speaker/dp/BBBBBBBBBB?psc=1&SubscriptionId=AKIAIYHMBBZCAVFTSEKQ&tag=goodgifts0c-20&linkCode=xm2&camp=2025&creative=165953&creativeASIN=B0145EVLMM';
        $productA = factory(Product::class)->create([
            'itemid'      => 'AAAAAAAAAA',
            'title'       => 'A Product',
            'description' => 'A Description',
            'link'        => $linkA,
            'image'       => 'A-image',
            'price'       => '$AAA'
        ]);
        $productB = factory(Product::class)->create([
            'itemid'      => 'BBBBBBBBBB',
            'title'       => 'B Product',
            'description' => 'B Description',
            'link'        => $linkB,
            'image'       => 'B-image',
            'price'       => '$BBB',
            'available'   => true
        ]);

        $article = $this->makeArticleWithProducts([$productA->toArray()]);

        $new_body = ArticleBody::html($article->body)->updateTextLink($productA->itemid, $productB->link);

        $this->assertContains($linkB, $new_body);
    }

    /**
     *@test
     */
    public function it_can_replace_a_product_card_with_a_new_product()
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

        $article = $this->makeArticleWithProducts([$productA->toArray()]);
        $article->attachProducts(collect($productA));

        $new_body = ArticleBody::html($article->body)->replaceProductCard($productA, $productB);

        $this->assertContains(ProductHtml::innerFor($productB->toArray()), $new_body);
        $this->assertNotContains(ProductHtml::innerFor($productA->toArray()), $new_body);
    }

    /**
     *@test
     */
    public function updating_a_product_card_does_not_include_new_body_tags()
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

        $article = $this->makeArticleWithProducts([$productA->toArray()]);
        $article->attachProducts(collect($productA));

        $new_body = ArticleBody::html($article->body)->replaceProductCard($productA, $productB);

        $this->assertNotContains('<body>', $new_body);
    }
}