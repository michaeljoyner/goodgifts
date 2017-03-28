<?php


namespace App\Products;


class ProductUpdate
{
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function execute()
    {
        $this->products->chunk(10)->each(function($batch) {
           $this->updateBatch($batch);
        });
    }

    protected function updateBatch($batch)
    {
        $lookup = app()->make(Lookup::class);
        $updatedProducts = $lookup->withId($this->extractBatchItemIds($batch));

        $updatedProducts->each(function ($updatedProduct) {
            $this->updateProductRecord($updatedProduct);
        });
    }

    protected function extractBatchItemIds($batch) {
        return implode(',', $batch->pluck('itemid')->toArray());
    }

    protected function updateProductRecord($updatedProduct)
    {
        $product = Product::where('itemid', $updatedProduct->itemid)->first();
        if ($product) {
            $product->update([
                'title' => $updatedProduct->title,
                'image' => $updatedProduct->image,
                'price' => $updatedProduct->price,
                'link'  => $updatedProduct->link
            ]);
        }
    }
}