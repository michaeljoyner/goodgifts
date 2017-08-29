<?php


namespace App\Products;


use App\Articles\Article;
use App\Suggestions\Suggestion;
use App\Tags\Tag;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['title', 'itemid', 'price', 'description', 'link', 'image', 'available'];

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
}