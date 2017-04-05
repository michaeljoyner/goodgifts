<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function delete(Product $product)
    {
        $product->delete();

        return redirect('/admin/issues');
    }
}
