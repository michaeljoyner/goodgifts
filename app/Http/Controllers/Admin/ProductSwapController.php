<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSwapController extends Controller
{
    public function show(Product $product)
    {
        return view('admin.products.swap.show', ['product' => $product]);
    }
}
