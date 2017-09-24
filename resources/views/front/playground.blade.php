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
    @include('front.partials.navbar')
    <header class="main-hero">
        <div class="hero-text">
            <p class="hero-tagline">Give more than a f<span class="fuck-censorship">
                    @include('svgicons.gift')
                </span>ck.</p>
            <p class="hero-sub-tag">Get a list of great gift ideas, based on his interests and your budget, sent
                                    straight to you, 20 days before his big day.</p>
        </div>
    </header>
    <div class="site-actions">
        <a class="main-cta action"
           href="/recommendations/signup">
            @include('svgicons.gift_card')
            Get a custom list
        </a>
        <a class="main-cta inspire"
           href="#articles">
            @include('svgicons.light_bulb')
            Get Inspiration
        </a>
    </div>
    <section class="reminder">
        <h3 class="heading">It's like the ultimate birthday reminder</h3>
        <div>
            <div class="text-block">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, nesciunt, quisquam? Adipisci
                   aliquam doloribus sapiente? A accusamus, accusantium architecto aspernatur autem facere facilis
                   mollitia nemo nihil, officiis quae quam voluptas.</p>
                <a class="main-cta action"
                   href="/recommendations/signup">
                    @include('svgicons.gift_card')
                    Get your list
                </a>
            </div>
            <img src="/images/list_screen.png"
                 alt="Screen shot of gift list"
                 class="screen-shot"
            >
        </div>
    </section>
    <section class="human-made">
        <h3 class="heading">Made by humans, for good people.</h3>
        <div>
            <div>
                <img src=""
                     alt="">
            </div>
            <div class="text-block">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus dolore eaque earum impedit, incidunt suscipit temporibus! Blanditiis doloremque est minima rerum voluptatem. Blanditiis culpa expedita fugit impedit, incidunt quia quis.</p>
            </div>
        </div>
    </section>
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
