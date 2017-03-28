<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlePublishingController extends Controller
{
    public function update(Request $request, Article $article)
    {
        $this->validate($request, [
            'publish' => 'required|boolean',
            'published_on' => 'date'
        ]);

        $request->publish ? $article->publish(request('published_on', null)) : $article->retract(request('published_on', null));

        return response()->json([
            'published' => $article->fresh()->published,
            'published_on' => $article->fresh()->published_on->format('Y-m-d')
        ]);
    }
}
