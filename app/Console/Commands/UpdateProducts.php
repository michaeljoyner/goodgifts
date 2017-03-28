<?php

namespace App\Console\Commands;

use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Console\Command;

class UpdateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the products in db';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        Product::all()->chunk(10)->each(function ($batch) {
//            $lookup = app()->make(Lookup::class);
//            $itemIds = implode(',', $batch->pluck('itemid')->toArray());
//            $updatedProducts = $lookup->withId($itemIds);
//
//            $updatedProducts->each(function ($updatedProduct) {
//                $product = Product::where('itemid', $updatedProduct->itemid)->first();
//                if ($product) {
//                    $product->update([
//                        'title' => $updatedProduct->title,
//                        'image' => $updatedProduct->image,
//                        'price' => $updatedProduct->price,
//                        'link'  => $updatedProduct->link
//                    ]);
//                }
//            });
//        });
        $update = new \App\Products\ProductUpdate(Product::all());
        $update->execute();
    }
}
