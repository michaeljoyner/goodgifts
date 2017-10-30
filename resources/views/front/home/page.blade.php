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
    @include('front.home.hero')
    @include('front.home.ultimate-reminder')
    @include('front.home.need-something-now')
    @include('front.home.made-by-people')
    @include('front.home.spread-the-word')
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
