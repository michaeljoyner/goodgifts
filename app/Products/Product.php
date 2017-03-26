<?php


namespace App\Products;


use App\Articles\Article;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['title', 'itemid', 'price', 'description', 'link', 'image'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}