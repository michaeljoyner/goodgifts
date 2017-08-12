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
    @include('front.partials.socialherolinks')
    <header class="main-hero">
        {{--<banner-canvas logo="/images/goodforguys.png" colour="#f88008"></banner-canvas>--}}
    </header>
    <div class="text-block">
        <p class="hero-tagline">Oh hey there, sexy.</p>
        <p class="hero-sub-tag">Yeah, we do gifts. Really cool ones, too.</p>
        <p class="hero-sub-tag">Check out our gift guides in the pics below.</p>
        <p class="hero-sub-tag">But for the real honey, get a free custom gift list &mdash; all the best gifts sent straight to you, just when you need it.</p>
    </div>
    <div class="article-grid">
        @foreach($articles as $article)
            <article-preview image="{{ $article->titleImage('thumb') }}"
                             title="{{ $article->title }}"
                             preview_text="{{ $article->intro }}"
                             article_link="/articles/{{ $article->slug }}"
            ></article-preview>
        @endforeach
        @if($articles->count() % 3 !== 0)
            <div class="article-grid-filler for-non-mobile">
                <a href="/recommendations/signup">Get a custom list</a>
            </div>
        @endif
        @if($articles->count() % 2 !== 0)
            <div class="article-grid-filler mobile-only">
                <a href="/recommendations/signup">Get a custom list</a>
            </div>
        @endif
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
