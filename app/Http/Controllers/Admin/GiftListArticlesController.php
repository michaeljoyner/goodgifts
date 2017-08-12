<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use App\GiftLists\GiftList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftListArticlesController extends Controller
{

    public function index(GiftList $list)
    {
        return $list->articles;
    }

    public function store(GiftList $list, Article $article)
    {
        $list->addArticle($article);
    }

    public function delete(GiftList $list, Article $article)
    {
        $list->removeArticle($article);
    }
}
