<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesController extends Controller
{

    public function index()
    {
        $articles = Article::latest()->paginate(15);

        return view('admin.articles.index')->with(compact('articles'));
    }

    public function show(Article $article)
    {
        return view('admin.articles.show')->with(compact('article'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|max:255', 'description' => 'required']);

        $article = \App\Articles\Article::create($request->all());

        return redirect('/admin/articles/' . $article->id);
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit')->with(compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->validate($request, ['title' => 'required|max:255', 'description' => 'required']);
        $article->update($request->intersect(['title', 'description']));
        return redirect('admin/articles/' . $article->id);
    }
}
