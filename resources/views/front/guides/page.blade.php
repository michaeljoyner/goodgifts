@extends('front.base', ['pageName' => ''])

@section('title')
    The Ultimate Gift Guides for Guys
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => url('/images/assets/fb_image.png'),
        'ogTitle' => 'The Ultimate Gift Guides for Guys',
        'ogDescription' => 'A broad collection of in-depth guides for finding a gift for a particular kind of guy. There is something for everyone.'
    ])
@endsection

@section('content')
    @include('front.partials.navbar')
    <header>
        <h1 class="f3 f1-ns strong-font tc">Gift Guides for Guys</h1>
        <p class="f5 f4-ns tc col-gr mh3 measure-wide lh-copy center-ns">Get some inspiration from our hand-crafted gift guides. They are full of helpful ideas, added info and all you need to find the perfect gift.</p>
    </header>
    <section>
        <div class="flex flex-wrap mw8 center justify-between mh3 mh4-ns" id="articles">
            @foreach($articles as $article)
                <article-preview image="{{ $article['image'] }}"
                                 title="{{ $article['title'] }}"
                                 article_target="{{ $article['target'] }}"
                                 preview_text="{{ $article['intro'] }}"
                                 article_link="{{ $article['article_link'] }}"
                                 grad="{{ ($loop->index % 20) + 1 }}"
                                 :is_real="{{ $article['is_real'] ? 'true' : 'false' }}"
                ></article-preview>
            @endforeach
        </div>
    </section>
@endsection