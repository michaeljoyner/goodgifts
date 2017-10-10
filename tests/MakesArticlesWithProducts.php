<?php


namespace Tests;


use App\Articles\Article;
use App\Products\ProductHtml;

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
        $products = collect($products)->map(function ($product) {
            $str = '';
            $str .= '<h4>A product sub title</h4>';
            $str .= '<p>This is some product information and text that might be interpreted by someone as an invitation to by some of their good from a store online, kidding, <a href="' . $product['link'] . '" class="amzn-text-link">A product text link</a> it is just dummy text.</p>';
            $str .= $this->makeProductHtml($product);
            return $str;
        })->toArray();

        $body = str_replace(PHP_EOL, '', implode('', $products));

        return factory(Article::class)->create(['body' => $body]);
    }

    protected function makeProductHtml($product)
    {
        return ProductHtml::for($product);
    }
}