<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTagsController extends Controller
{
    public function store(Product $product)
    {
        $this->validate(request(), ['tags' => 'required|array']);

        $product->setTags(request('tags'));

        return $product->fresh()->tags->pluck('tag')->toArray();
    }
}
