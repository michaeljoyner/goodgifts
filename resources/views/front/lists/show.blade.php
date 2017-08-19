@extends('front.base')

@section('head')
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
@endsection

@section('content')
    @include('front.partials.standardheader')
    <div class="gift-list-page-container">
        <h1 class="greeting">Hey {{ $list->requested_by }}, here is that list you asked for.</h1>
        <div class="card-info-strip">
            <div>
                <p class="info-label">Gifts for</p>
                <p class="info-text">{{ $list->for }}</p>
            </div>
            <div>
                <p class="info-label">Budget</p>
                <p class="info-text">{{ $list->budget }}</p>
            </div>
            <div>
                <p class="info-label">Interests</p>
                <p class="info-text">{{ $list->interests }}</p>
            </div>
        </div>
        <div class="suggestion-list">
            @foreach($list->suggestionList() as $item)
                <div class="gift-list-product">
                    <div class="image-box">
                        <a href="{{ $item->product->link }}"><img src="{{ $item->product->image }}" alt=""></a>
                    </div>
                    <div class="details">
                        <p class="title">{{ $item->what }}</p>
                        <p>Why: {{ $item->why }}</p>
                        <a class="price-tag" href="{{ $item->product->link }}">
                            <span class="vendor-name">Amazon</span><span class="inner-price">{{ $item->product->price }}</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="gift-list-articles">
            <p class="prompt">You may also find these articles useful.</p>
            @foreach($list->articles as $article)
                <div class="gift-list-article">
                    <div class="image-box">
                        <a href="/articles/{{ $article->slug }}"><img src="{{ $article->titleImage('thumb') }}" alt="{{ $article->title }}"></a>
                    </div>
                    <div class="details">
                        <a href="/articles/{{ $article->slug }}"><p class="title">{{ $article->title }}</p></a>
                        <p>{{ $article->intro }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="social-begging">
            <p>Like what we do?</p>
            <p>Help us spread the word.</p>
            <div class="icons">
                <a href="#">@include('svgicons.social.facebook-f')</a>
                <a href="#">@include('svgicons.social.instagram')</a>
            </div>
        </div>
    </div>
@endsection