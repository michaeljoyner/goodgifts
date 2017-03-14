<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductLookupController extends Controller
{
    public function show(\App\Products\Lookup $lookup)
    {
        $this->validate(request(), ['itemid' => 'required']);

        $product = $lookup->withId(request('itemid'));

        return response()->json([
            'title' => $product->title,
            'image' => $product->image,
            'description' => $product->description,
            'price' => $product->price,
            'link' => $product->link,
            'itemid' => $product->itemid
        ]);
    }
}
