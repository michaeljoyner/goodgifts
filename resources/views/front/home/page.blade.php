@extends('front.base', ['pageName' => 'home-page'])

@section('title')
    Good Gifts For Guys
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => '/images/logos/fb_logo.png',
        'ogTitle' => 'Good Gifts For Guys | Great gift ideas for the men in your life.',
        'ogDescription' => 'Here at Good Gifts For Guys, we are all about ideas. Ideas that you can use to help find that perfect gift, for any kind od man in your life, from the boyish beach bro to the dedicated dog lover and many, many more.'
    ])
@endsection

@section('content')
{{--    @include('front.partials.socialherolinks')--}}
    <header class="main-hero"></header>
    <div class="text-block">
        <p class="hero-tagline">The search is almost over.</p>
        <p class="hero-sub-tag">Whatever makes him tick, we’ll find him a gift.</p>
        <p class="hero-sub-tag">Click on the pics below for a little taste of what we do. But for the real honey, get a free, custom made gift list sent directly to you. All the best gifts, just when you need it.</p>
        <div class="social-links-home">
            <a class="instagram-link social-hero-link" href="https://www.instagram.com/good_gifts_for_guys/" target="_blank">@include('svgicons.social.instagram')</a>
            <a class="facebook-link social-hero-link" href="https://facebook.com/goodgiftsforguys" target="_blank">@include('svgicons.social.facebook-f')</a>
        </div>
    </div>
    <div class="article-grid">
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
