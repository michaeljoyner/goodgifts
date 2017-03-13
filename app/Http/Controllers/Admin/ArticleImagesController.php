<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleImagesController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $this->validate($request, ['image' => 'required|image']);

        $image = $article->addImage($request->file('image'));

        return response()->json(['location' => $image->getUrl('web')]);
    }
}
