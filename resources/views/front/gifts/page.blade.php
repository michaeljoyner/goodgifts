@extends('front.base', ['pageName' => ''])

@section('title')
    Instant Gift Ideas from GGFG
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => url('/images/assets/fb_image.png'),
        'ogTitle' => 'Instant Gift Ideas',
        'ogDescription' => 'Get great gift ideas based on your budget and his interests. We specialize in finding great gifts for guys.'
    ])
@endsection

@section('content')
    @include('front.partials.navbar')
    <header>
        <h1 class="f3 f1-ns strong-font tc">Find a Gift</h1>
        <p class="f5 tc col-gr measure-wide lh-copy center-ns mh3">We mix your budget with his interests to serve up the best gift ideas.</p>
    </header>
    <gifts-app></gifts-app>
@endsection

@section('bodyscripts')
    <script>
        gtag('event', 'conversion', {'send_to': 'AW-858669646/U0qnCPbcpnkQzoS5mQM'});
    </script>
@endsection