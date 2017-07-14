@extends('front.base')

@section('title')
    Good Gifts For Guys
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => '/images/assets/fb_image.png',
        'ogTitle' => 'Good Gifts For Guys | Great gift ideas for the men in your life.',
        'ogDescription' => 'Here at Good Gifts For Guys, we are all about ideas. Ideas that you can use to help find that perfect gift, for any kind od man in your life, from the boyish beach bro to the dedicated dog lover and many, many more.'
    ])
@endsection

@section('content')
    <header class="main-hero">
        @include('front.partials.socialherolinks')

        <h1 class="page-title">
            <span>Good Gifts</span><br>
            <span>For Guys.</span>
        </h1>
        <p class="hero-tagline">Only the cool stuff.</p>
        <p class="hero-sub-tag">Bite-size gift guides for inspiration.</p>
        <p class="hero-sub-tag">Custom made gift lists for free.</p>
        {{--<h2 class="page-subtitle"></h2>--}}
    </header>
    <div class="article-grid">
        @foreach($articles as $article)
            {{--<article class="article-listing">--}}
            {{--<div class="image-box">--}}
            {{--<a href="/articles/{{ $article->slug }}">--}}
            {{--<img class="article-title-image" src="{{ $article->titleImage('thumb') }}" alt="{{ $article->title }}">--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--<div class="text-box">--}}
            {{--<h3 class="article-title"><a href="/articles/{{ $article->slug }}">{{ $article->title }}</a></h3>--}}
            {{--<p class="article-description">{{ $article->intro }}</p>--}}
            {{--</div>--}}
            {{--</article>--}}
            {{--@if(Auth::check() && $loop->iteration === 3)--}}
            {{--<div class="reminder-signup-component">--}}
            {{--<h3 class="signup-ad-header">Get a personalised gift list</h3>--}}
            {{--<p class="signup-ad-copy">Totally free, sent straight to you.</p>--}}
            {{--<a href="/recommendations/signup" class="action-button">Hell yeah</a>--}}
            {{--</div>--}}
            {{--@endif--}}
            <article-preview image="{{ $article->titleImage('thumb') }}"
                             title="{{ $article->title }}"
                             preview_text="{{ $article->intro }}"
                             article_link="/articles/{{ $article->slug }}"
            ></article-preview>
            {{--@include('front.home.articlecard')--}}
        @endforeach
    </div>

@endsection

@section('bodyscripts')
    <script type='application/ld+json'>
    {
      "@context": "http://www.schema.org",
      "@type": "WebSite",
      "name": "Good Gifts For Guys",
      "alternateName": "Gift guides and ideas for the men in your life",
      "url": "https://goodgiftsforguys.com"
    }
 </script>
@endsection