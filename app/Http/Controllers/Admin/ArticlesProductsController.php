<?php

namespace App\Http\Controllers\Admin;

use App\Articles\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesProductsController extends Controller
{
    public function index(Article $article)
    {
        return $article->mentionedProducts();
    }
}
