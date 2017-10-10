<?php

namespace App\Http\Controllers\Admin;

use App\Amazon\AmazonId;
use App\Articles\Article;
use App\Products\Lookup;
use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesProductsController extends Controller
{
    public function index(Article $article)
    {
        return $article->products()->with('tags')->get();
    }

    public function show(Article $article)
    {
        return view('admin.articles.products.index')->with(compact('article'));
    }

    public function store(Article $article, Lookup $lookup)
    {
        list($existing, $new) = collect(explode(',', request('item_ids')))->map(function($id) {
            return AmazonId::parse($id);
        })->partition(function($id) {
            return Product::where('itemid', $id)->first();
        });


        if($new->count() > 0) {
            $newids = $lookup->withId(implode(',', $new->toArray()))->map(function($product) {
                $product->save();
                return $product->fresh()->id;
            })->toArray();
            $article->attachProducts($newids);
        }

        $article->attachProducts($existing->map(function($itemid) {
            return Product::where('itemid', $itemid)->first()->id;
        })->toArray());

        return $article->fresh()->products;
    }

    public function remove(Article $article, Product $product)
    {
        $article->products()->detach($product->id);

        if($product->fresh()->articles->count() === 0) {
            $product->delete();
        }
    }
}
