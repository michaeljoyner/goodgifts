<?php


namespace App\Products;


use App\Suggestions\Suggestion;

class TaggingIssuesRepository
{

    public function orphanProducts()
    {
        return Product::withCount('articles')->get()->filter(function($product) {
            return $product->articles_count == 0;
        });
    }

    public function unreasonedSuggestions()
    {
        return Suggestion::with(['product', 'article'])->get()->filter(function($suggestion) {
            if(!$suggestion->article || !$suggestion->product) {
                return false;
            }
            return !$suggestion->what && !$suggestion->why;
        });
    }

    public function untaggedProducts()
    {
        return Product::withCount('tags')->with('articles')->get()->filter(function($product) {
            return $product->tags_count == 0;
        });
    }
}