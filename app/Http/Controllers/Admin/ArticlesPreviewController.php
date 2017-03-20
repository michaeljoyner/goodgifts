<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesPreviewController extends Controller
{
    public function show(Article $article)
    {
        return view('front.articles.page')->with(compact('article'));
    }
}
