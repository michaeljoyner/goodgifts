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
    <header class="main-hero">
        <div class="hero-text">
            <p class="hero-tagline">Give more than a f<span class="fuck-censorship">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="30px" fill="#20e3b2">
		<path d="M316,271v241h120c24.814,0,46-20.186,46-45V271H316z"/>
		<path d="M30,271v196c0,24.814,20.186,45,45,45h121V271H30z"/>
		<path d="M467,120h-61.383C415.135,107.426,421,91.948,421,75c0-41.353-33.647-75-75-75c-52.343,0-67.498,37.705-90,94.803
			C233.498,37.705,218.343,0,166,0c-41.353,0-75,33.647-75,75c0,16.948,5.865,32.426,15.383,45H45c-24.814,0-45,20.186-45,45v31
			c0,24.814,20.186,45,45,45h151V120h-30c-24.814,0-45-20.186-45-45c0-24.814,20.186-45,45-45c30.747,0,39.492,18.442,62.476,76.758
			c1.602,4.072,3.6,8.903,5.327,13.242H226c0,223.682,0,168.219,0,392h60c0-351.116,0-294.48,0-392h-7.802
			c1.727-4.34,3.724-9.17,5.327-13.242C306.508,48.442,315.253,30,346,30c24.814,0,45,20.186,45,45c0,24.814-20.186,45-45,45h-30
			v121h151c24.814,0,45-20.186,45-45v-31C512,140.186,491.814,120,467,120z"/>
</svg>

                </span>ck.</p>
            <p class="hero-sub-tag">Get a list of great gift ideas, based on his interests and your budget, sent straight to you, 20 days before his big day.</p>
        </div>
    </header>
    <div class="site-actions">
        <a class="main-cta action" href="/recommendations/signup">
            <svg fill="#fd746c" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
            Get a custom list
        </a>
        <a class="main-cta inspire" href="#articles">
            <svg fill="#0099F7" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <path d="M0 0h24v24H0V0z" id="a"/>
                </defs>
                <clipPath id="b">
                    <use overflow="visible" xlink:href="#a"/>
                </clipPath>
                <path clip-path="url(#b)" d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7zm2.85 11.1l-.85.6V16h-4v-2.3l-.85-.6C7.8 12.16 7 10.63 7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.15 4.1z"/>
            </svg>
            Get Inspiration
        </a>
    </div>
    <div class="sub-hero">

        <div class="social-links-home">
            <a class="instagram-link social-hero-link" href="https://www.instagram.com/good_gifts_for_guys/"
               target="_blank">@include('svgicons.social.instagram')</a>
            <a class="facebook-link social-hero-link" href="https://facebook.com/goodgiftsforguys"
               target="_blank">@include('svgicons.social.facebook-f')</a>
        </div>
        {{--<p class="">Click on the pics below for a little taste of what we do. But for the real honey, get a--}}
            {{--free, custom made gift list sent directly to you. All the best gifts, just when you need it.</p>--}}
    </div>
    <div class="article-grid" id="articles">
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
