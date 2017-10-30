<?php

namespace App\Http\Controllers;

use App\Articles\Article;
use App\Products\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
//        $articles = Article::published()->latest('published_on')->get()->map->toPreviewArray();
//        $filler_count = 3 - ($articles->count() % 3);
//
//        while ($filler_count > 0 && $filler_count < 3) {
//            $articles->push([
//                'title' => 'Get a Free Custom Gift List',
//                'image' => '/images/ggfg_banner_mobile.jpg',
//                'article_link' => '/recommendations/signup',
//                'intro' => 'Get a free custom made gift list for any guy, based on his interests, and your budget, sent directly to you 20 days before gift day',
//                'target' => 'Any Guy You Know',
//                'is_real' => false
//            ]);
//            $filler_count -= 1;
//        }
        $featured_images = Product::where('featured', true)->get()->map(function($product) {
            return $product->image;
        });

        return view('front.home.page', [
            'featured_images' => $featured_images
        ]);
    }

    public function article($slug)
    {
        $article = Article::published()->where('slug', $slug)->firstOrFail();

        return view('front.articles.page')->with(compact('article'));
    }

    public function playground()
    {
        return view('front.playground');
    }

    public function guides()
    {
        $articles = Article::published()->latest('published_on')->get()->map->toPreviewArray();
        $filler_count = 3 - ($articles->count() % 3);

        while ($filler_count > 0 && $filler_count < 3) {
            $articles->push([
                'title' => 'Get a Free Custom Gift List',
                'image' => '/images/ggfg_banner_mobile.jpg',
                'article_link' => '/recommendations/signup',
                'intro' => 'Get a free custom made gift list for any guy, based on his interests, and your budget, sent directly to you 20 days before gift day',
                'target' => 'Any Guy You Know',
                'is_real' => false
            ]);
            $filler_count -= 1;
        }

        return view('front.guides.page', [
            'articles' => $articles->shuffle()
        ]);
    }

    public function gifts()
    {
        return view('front.gifts.page');
    }
}
