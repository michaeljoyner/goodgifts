<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductReasonsController extends Controller
{
    public function update(Article $article, Product $product)
    {
        $this->validate(request(), ['what' => 'required', 'why' => 'required']);

        $article->products()->updateExistingPivot($product->id, request()->only('what', 'why'));
    }
}
