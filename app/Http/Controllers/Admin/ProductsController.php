<?php

namespace App\Http\Controllers\Admin;

use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{

    public function update(Product $product, Lookup $lookup)
    {
        $this->validate(request(), ['amazon_id' => 'required']);

        $replacement = $lookup->withId(request('amazon_id'))->first();

        $product->replaceWith($replacement);

        return $product->fresh();
    }

    public function delete(Product $product)
    {
        $product->delete();

        return redirect('/admin/issues');
    }
}
