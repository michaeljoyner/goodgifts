<?php

namespace App\Http\Controllers;

use App\Articles\Article;
use Illuminate\Http\Request;

class ArticleTextController extends Controller
{
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();
        return strip_tags($article->body);
    }
}
