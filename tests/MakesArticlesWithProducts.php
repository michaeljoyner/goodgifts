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
        $productHtmlTemplate = '<div class="amazon-product-card" data-amzn-id="%s"><p class="amazon-product-title">%s</p><img src="%s" alt="%s"><a href="%s">At Amazon for %s</a></div>';

        $products = collect($products)->map(function ($product) use ($productHtmlTemplate) {
            return sprintf($productHtmlTemplate, $product['itemid'], $product['title'], $product['image'],
                $product['title'], $product['link'], $product['price']);
        })->toArray();

        $body = implode('', $products);

        return factory(Article::class)->create(['body' => $body]);
    }
}