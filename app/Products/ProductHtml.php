<?php


namespace App\Products;


class ProductHtml
{
    public static function for($product)
    {
        $productHtmlTemplate = '<div class="amazon-product-card" data-amzn-id="%s"><p class="amazon-product-title">%s</p><div class="product-image-box"><a href="%s"><img src="%s" alt="%s"></a></div><a href="%s"><span class="vendor-name">amazon</span><span class="inner-price">%s</span></a></div>';

        return sprintf($productHtmlTemplate, $product['itemid'], $product['title'], $product['link'], $product['image'],
            $product['title'], $product['link'], $product['price']);

    }

    public static function innerFor($product)
    {
        $productHtmlTemplate = '<p class="amazon-product-title">%s</p><div class="product-image-box"><a href="%s"><img src="%s" alt="%s"></a></div><a href="%s"><span class="vendor-name">amazon</span><span class="inner-price">%s</span></a>';

        return sprintf($productHtmlTemplate, $product['title'], $product['link'], $product['image'],
            $product['title'], $product['link'], $product['price']);
    }
}