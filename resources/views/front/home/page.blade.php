@extends('front.base')

@section('title')
    Good Gifts For Guys | Great gift ideas for the men in your life.
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => '/images/assets/fb_image.jpg',
        'ogTitle' => 'Good Gifts For Guys | Great gift ideas for the men in your life.',
        'ogDescription' => 'Here at Good Gifts For Guys, we are all about ideas. Ideas that you can use to help find that perfect gift, for any kind od man in your life, from the boyish beach bro to the dedicated dog lover and many, many more.'
    ])
@endsection

@section('content')
    <header class="main-hero">
        <h1 class="page-title">Good Gifts</h1>
        <h2 class="page-subtitle">For Guys.</h2>
    </header>
    @foreach($articles as $article)
    <article class="article-listing">
        <div class="image-box">
            <a href="/articles/{{ $article->slug }}">
                <img class="article-title-image" src="{{ $article->titleImage('web') }}" alt="{{ $article->title }}">
            </a>
        </div>
        <div class="text-box">
            <h3 class="article-title"><a href="/articles/{{ $article->slug }}">{{ $article->title }}</a></h3>
            <p class="article-description">{{ $article->intro }}</p>
        </div>
    </article>
    @endforeach
@endsection