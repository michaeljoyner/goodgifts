<?php


namespace App\Products;


use App\Articles\Article;
use App\Events\ProductReplaced;
use App\Suggestions\Suggestion;
use App\Tags\Tag;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['title', 'itemid', 'price', 'description', 'link', 'image', 'available'];

    protected $casts = ['available' => 'boolean'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setTags($tags)
    {
        $tag_ids = collect($tags)->map(function($tag) {
            return Tag::firstOrCreate(['tag' => $tag]);
        })->pluck('id')->toArray();
        $this->tags()->sync($tag_ids);
    }

    public function suggestions()
    {
        return $this->hasMany(Suggestion::class, 'product_id');
    }

    public function replaceWith(Product $product)
    {
        $original_item = clone $this;
        $this->update([
            'itemid' => $product->itemid,
            'title' => $product->title,
            'image' => $product->image,
            'description' => $product->description,
            'price' => $product->price,
            'link' => $product->link,
            'available' => $product->available
        ]);

        $this->articles->each->replaceProductInBody($original_item, $this->fresh());
        event(new ProductReplaced($this));
    }
}