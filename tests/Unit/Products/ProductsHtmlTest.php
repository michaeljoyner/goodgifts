<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use App\Products\ProductHtml;
use Tests\TestCase;

class ProductsHtmlTest extends TestCase
{
    /**
     *@test
     */
    public function it_produces_the_correct_html_for_a_given_product()
    {
        $product = factory(Product::class)->make([
            'title' => 'The title',
            'image' => '/the/image.jpg',
            'price' => '$10.00',
            'link' => '/the/products/link',
            'itemid' => 'BC00TEST00'
        ]);

        $expectedHtml = '<div class="amazon-product-card" data-amzn-id="BC00TEST00"><p class="amazon-product-title">The title</p><div class="product-image-box"><a href="/the/products/link"><img src="/the/image.jpg" alt="The title"></a></div><a href="/the/products/link"><span class="vendor-name">amazon</span><span class="inner-price">$10.00</span></a></div>';

        $this->assertEquals($expectedHtml, ProductHtml::for($product));
    }

    /**
     *@test
     */
    public function it_produces_the_correct_html_from_an_array()
    {
        $product = [
            'title' => 'The title',
            'image' => '/the/image.jpg',
            'price' => '$10.00',
            'link' => '/the/products/link',
            'itemid' => 'BC00TEST00'
        ];

        $expectedHtml = '<div class="amazon-product-card" data-amzn-id="BC00TEST00"><p class="amazon-product-title">The title</p><div class="product-image-box"><a href="/the/products/link"><img src="/the/image.jpg" alt="The title"></a></div><a href="/the/products/link"><span class="vendor-name">amazon</span><span class="inner-price">$10.00</span></a></div>';

        $this->assertEquals($expectedHtml, ProductHtml::for($product));
    }

    /**
     *@test
     */
    public function it_outputs_the_correct_inner_html_for_a_product()
    {
        $product = factory(Product::class)->make([
            'title' => 'The title',
            'image' => '/the/image.jpg',
            'price' => '$10.00',
            'link' => '/the/products/link',
            'itemid' => 'BC00TEST00'
        ]);

        $expectedHtml = '<p class="amazon-product-title">The title</p><div class="product-image-box"><a href="/the/products/link"><img src="/the/image.jpg" alt="The title"></a></div><a href="/the/products/link"><span class="vendor-name">amazon</span><span class="inner-price">$10.00</span></a>';

        $this->assertEquals($expectedHtml, ProductHtml::innerFor($product));
    }

    /**
     *@test
     */
    public function it_outputs_the_correct_inner_html_for_an_array_product()
    {
        $product = [
            'title' => 'The title',
            'image' => '/the/image.jpg',
            'price' => '$10.00',
            'link' => '/the/products/link',
            'itemid' => 'BC00TEST00'
        ];

        $expectedHtml = '<p class="amazon-product-title">The title</p><div class="product-image-box"><a href="/the/products/link"><img src="/the/image.jpg" alt="The title"></a></div><a href="/the/products/link"><span class="vendor-name">amazon</span><span class="inner-price">$10.00</span></a>';

        $this->assertEquals($expectedHtml, ProductHtml::innerFor($product));
    }
}