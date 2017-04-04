<?php


namespace App\Issues;


use App\Products\Product;

trait HasIssueProducts
{
    public function products()
    {
        $productIds = explode(',', $this->product_ids);

        return Product::find($productIds);
    }
}