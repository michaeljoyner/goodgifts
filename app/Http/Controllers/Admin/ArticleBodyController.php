<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleBodyController extends Controller
{
    public function edit(Article $article)
    {
        return view('admin.articles.body.edit')->with(compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $article->update(['body' => $request->body]);
    }
}
