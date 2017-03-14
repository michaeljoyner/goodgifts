<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleTitleImageController extends Controller
{
    public function update(Request $request, Article $article)
    {
        $this->validate($request, ['image' => 'required|image']);

        $article->setTitleImage($request->image);
    }
}
