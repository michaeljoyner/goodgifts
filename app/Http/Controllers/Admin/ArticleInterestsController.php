<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use App\Http\Requests\ArticleInterestsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleInterestsController extends Controller
{
    public function index(Article $article)
    {
        return $article->interests->pluck('interest');
    }

    public function store(ArticleInterestsRequest $request, Article $article)
    {
        $interests = $article->setInterests($request->interestList());
        return $interests->pluck('interest');
    }
}
