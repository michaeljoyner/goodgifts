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
    @include('front.partials.navbar')
    <section class="db flex-ns justify-between-ns mw8-ns center pb5 pt4">
        <div class="w5-ns flex db-ns justify-center items-center">
            <img src="/images/logos/ggfg_logo_seethrough.png"
                 alt="Goodgiftsforguys logo" class="db w-50 w-100-ns">
        </div>
        <div class="mw6 pr5-ns overflow-hidden">
            <p class="strong-font tc tl-ns f4 f2-ns an-slide-in">Give more than a f<span class="">
                    @include('svgicons.hero.gift', ['classNames' => 'h1 h2-ns'])
                </span>ck.</p>
            <p class="lh-copy measure strong-font f5 f4-ns col-gr ph2 ph0-ns tc tl-ns">Get a list of great gift ideas, based on his interests and your budget, sent straight to you, 20 days before his big day.</p>
            <div class="flex flex-column flex-row-ns">
                <a class="flex items-center ba bw2 pa2 strong-font mh2 ml0-ns mb3 mb0-ns ttu mr3-ns" href="/recommendations/signup">
                    @include('svgicons.hero.gift-card', ['classNames' => 'mr2'])
                    Get a custom list
                </a>
                <a class="flex items-center ba bw2 pa2 strong-font ttu mh2 mh0-ns" href="#articles">
                    @include('svgicons.hero.light-bulb', ['classNames' => 'mr2'])
                    Get Inspiration
                </a>
            </div>
        </div>
    </section>
    <section class="pv5 col-p-bg relative overflow-hidden">
        <p class="f2 tc mt0 strong-font">It's the ultimate birthday reminder</p>
        <div class="flex mw8 center">
            <div class="ph3 w-50">
                <p class="measure lh-copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet, cumque delectus distinctio dolorum eos, fuga illum ipsa ipsum minus, nam natus officiis quasi quibusdam quis repudiandae tempore voluptatem. Ad, quidem.</p>
                <p class="measure lh-copy">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ad culpa cumque debitis doloribus enim eum, incidunt ipsa magnam minus nam neque officiis omnis optio possimus quia sapiente, soluta velit.</p>
                <a class="inline-flex mt5 items-center ba bw2 pa2 strong-font ttu mr3" href="/recommendations/signup">
                    @include('svgicons.hero.gift-card', ['classNames' => 'mr2'])
                    Get a custom list
                </a>
            </div>
            <div class="w-50">
                <img src="/images/list_screen.png"
                     alt="Screen shot of gift list"
                     class="w-50 absolute right--2"
                >
            </div>
        </div>
    </section>


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
