<?php

namespace App\Suggestions;

use App\Products\Product;
use App\Tags\Tag;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $table = 'article_product';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function forTags($tagNames)
    {
        $products = Tag::productsFor($tagNames);

        return static::with('product')->whereIn('product_id', $products->pluck('id')->all())->get();
    }

    public static function byProductName($productName)
    {
        $products = Product::where('title', 'LIKE', "%$productName%")->get();
        return static::with('product')->whereIn('product_id', $products->pluck('id')->all())->get();
    }
}
