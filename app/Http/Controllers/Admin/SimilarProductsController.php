<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use App\Products\SimilarSearch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SimilarProductsController extends Controller
{
    public function index($itemid, SimilarSearch $similarSearch)
    {
        $products = $similarSearch->for($itemid)->filter(function($product) {
            return $product->available;
        })->toArray();

        return response()->json($products);
    }

    public function show(Product $product)
    {
        return view('admin.products.similar.show')->with(compact('product'));
    }
}
