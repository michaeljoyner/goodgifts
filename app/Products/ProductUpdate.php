<?php


namespace App\Products;


use App\Issues\BatchUpdateIssue;
use App\Issues\IncompleteUpdateIssue;
use App\Issues\Issue;
use App\Issues\UnavailableProductIssue;

class ProductUpdate
{
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function execute()
    {
        $this->products->chunk(10)->each(function ($batch) {
            $this->updateBatch($batch);
        });
    }

    protected function updateBatch($batch)
    {
        $lookup = app()->make(Lookup::class);

        try {
            $updatedProducts = $lookup->withId($this->extractBatchItemIds($batch));
        } catch (\Exception $e) {
            Issue::createBatchUpdateIssue($e->getMessage(), [
                'product_ids' => implode(',', $batch->pluck('id')->toArray())
            ]);
            $updatedProducts = collect([]);
        }

        $missedLookups = $batch->filter(function ($product) use ($batch, $updatedProducts) {
            $missedItems = $batch->pluck('itemid')->diff($updatedProducts->pluck('itemid'));

            return $missedItems->contains($product->itemid);
        });

        if ($missedLookups->count() > 0) {
            Issue::createIncompleteUpdateIssue('Some products were never returned from the lookup',
                ['product_ids' => implode(',', $missedLookups->pluck('id')->toArray())]);
        }

        $updatedProducts->each(function ($updatedProduct) {
            if ($updatedProduct->available === false) {
                $existingProduct = Product::where('itemid', $updatedProduct->itemid)->first();
                if ($existingProduct) {
                    Issue::createUnavailableProductIssue($existingProduct->title . ' is not currently available',
                        ['product_id' => $existingProduct->id]);
                }
            } else {
                $this->updateProductRecord($updatedProduct);
            }
        });
    }

    protected function extractBatchItemIds($batch)
    {
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