<?php

namespace App\Http\Controllers;

use App\Articles\Article;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        $articles = Article::published()->latest('published_on')->get();
        return view('front.home.page')->with(compact('articles'));
    }

    public function article($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        return view('front.articles.page')->with(compact('article'));
    }
}
