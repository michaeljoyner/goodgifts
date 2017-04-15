<?php


namespace Tests;


use App\Articles\Article;

trait MakesArticlesWithProducts
{
    protected function getTestProducts()
    {
        return [
            [
                'itemid' => 'ABC123',
                'title'  => 'Example One',
                'link'   => 'https://example.com/1',
                'image'  => 'test-image-link-1',
                'price'  => 'test-price-1'
            ],
            [
                'itemid' => 'ABC456',
                'title'  => 'Example Two',
                'link'   => 'https://example.com/2',
                'image'  => 'test-image-link-2',
                'price'  => 'test-price-2'
            ],
            [
                'itemid' => 'ABC789',
                'title'  => 'Example Three',
                'link'   => 'https://example.com/3',
                'image'  => 'test-image-link-3',
                'price'  => 'test-price-3'
            ]
        ];
    }

    protected function makeArticleWithProducts($products)
    {
        $productHtmlTemplate = '<div class="amazon-product-card" data-amzn-id="%s"><p class="amazon-product-title">%s</p><img src="%s" alt="%s"><a href="%s"><span class="vendor-name">amazon</span><span class="inner-price">%s</span></a></div>';

        $products = collect($products)->map(function ($product) use ($productHtmlTemplate) {
            $str = '';
            $str .= '<h4>A product sub title</h4>';
            $str .= '<p>This is some product information and text that might be interpreted by someone as an invitation to by some of their good from a store online, kidding, it is just dummy text.</p>';
            $str .= sprintf($productHtmlTemplate, $product['itemid'], $product['title'], $product['image'],
                $product['title'], $product['link'], $product['price']);
            return $str;
        })->toArray();

        $body = implode('', $products);

        return factory(Article::class)->create(['body' => $body]);
    }
}