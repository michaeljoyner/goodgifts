<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlePosterController extends Controller
{
    public function show(Article $article)
    {
        return view('admin.articles.posters.show')->with(compact('article'));
    }
}
