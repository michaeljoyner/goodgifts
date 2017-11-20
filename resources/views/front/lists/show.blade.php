@extends('front.base')

@section('head')
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
@endsection

@section('content')
    @include('front.partials.navbar')
    <div class="mw7 center-l mh3">
        <h1 class="f3 f2-ns">Hey {{ $list->requested_by }}, here is that list you asked for.</h1>
        <div class="col-w-bg pv3 mv4 flex justify-between">
            <div class="w-30-ns">
                <p class="ttu f6 col-p strong-font mb0">Gifts for</p>
                <p class="mt1">{{ $list->for }}</p>
            </div>
            <div class="w-30-ns">
                <p class="ttu f6 col-p strong-font mb0">Budget</p>
                <p class="mt1">{{ $list->budget }}</p>
            </div>
            <div class="w-30-ns">
                <p class="ttu f6 col-p strong-font mb0">Interests</p>
                <p class="mt1">{{ $list->interests }}</p>
            </div>
        </div>
        <div class="">
            @foreach($list->suggestionList() as $item)
                <div class="flex-ns col-p ba col-w-bg pa2 mv3">
                    <div class="flex center justify-center items-center w200p h200p mr4">
                        <a href="{{ $item->product->link }}"><img src="{{ $item->product->image }}" alt="" class="mw-100 maxh-150"></a>
                    </div>
                    <div class="relative flex-auto">
                        <p class="f4-ns strong-font col-d">{{ $item->what }}</p>
                        <p class="col-d">Why: {{ $item->why }}</p>
                        <a class="price-tag absolute bottom-0 right-0" href="{{ $item->product->link }}">
                            <span class="vendor-name">Amazon</span><span class="inner-price">{{ $item->product->price }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="gift-list-articles">
            <p class="strong-font mv4">You may also find these articles useful.</p>
            @foreach($list->articles as $article)
                <div class="flex col-d ba pa1 pa2-ns mv3">
                    <div class="flex justify-center items-center w200p mr3 mr4-ns mw-40">
                        <a href="/articles/{{ $article->slug }}"><img src="{{ $article->titleImage('thumb') }}" alt="{{ $article->title }}" class="mw-100"></a>
                    </div>
                    <div class="flex-auto">
                        <a href="/articles/{{ $article->slug }}" class="link"><p class="strong-font col-d mt0 hov-p">{{ $article->title }}</p></a>
                        <p class="dn db-ns">{{ $article->intro }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="tc mv4">
            <p class="f6 f5-ns strong-font">Want more like this?</p>
            <a class="inline-flex mt2 items-center ba bw2 pa2 strong-font ttu link col-d hov-p" href="/recommendations/signup">Get another list</a>
        </div>
        <div class="tc">
            <p class="col-d mb0 strong-font f5 f4-ns">Like what we do?</p>
            <p class="col-d mt1 strong-font f5 f4-ns">Help us spread the word.</p>
            <div class="flex items-center center justify-center mv4">
                <a href="https://www.facebook.com/goodgiftsforguys" class="col-d hov-p">@include('svgicons.social.facebook-f')</a>
                <a href="https://www.instagram.com/good_gifts_for_guys/" class="col-d hov-p">@include('svgicons.social.instagram')</a>
            </div>
        </div>
    </div>
@endsection