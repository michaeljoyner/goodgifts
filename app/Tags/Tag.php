<?php

namespace App\Tags;

use App\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['tag'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public static function productsFor($tagNames)
    {
        return static::whereIn('tag', $tagNames)->get()->flatMap(function($tag) {
            return $tag->products;
        })->groupBy('id')->map(function($group) {
            $count = $group->count();
            $product = $group->first();
            $product->match_score = $count;
            return $product;
        });
    }
}
