<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use App\Http\Controllers\Controller;

class FeaturedProductsController extends Controller
{

    public function index()
    {
        return view('admin.products.featured.index');
    }

    public function store()
    {
        request()->validate(['product_id' => 'required|exists:products,id']);

        Product::findOrFail(request('product_id'))->feature();
    }

    public function delete(Product $product)
    {
        $product->demote();
    }
}
