<?php

namespace App\Http\Controllers;

use App\Articles\Article;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class ArticleTextController extends Controller
{
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();

        if(request('exclude', false)) {
            $crawler = new Crawler();
            $crawler->addHtmlContent($article->body);
            $cards = $crawler->filter('.' . request('exclude'))->each(function($node) {
                $node->getNode(0)->nodeValue = '';
            });
            return strip_tags($crawler->html());
        }

        return strip_tags($article->body);

    }
}
