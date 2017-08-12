@extends('front.base')

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
                        <img src="{{ $item->product->image }}" alt="">
                    </div>
                    <div class="details">
                        <p class="title">{{ $item->what }}</p>
                        <p>Why: {{ $item->why }}</p>
                        <p class="price-tag" href="#">
                            <span class="vendor-name">Amazon</span><span class="inner-price">{{ $item->product->price }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="gift-list-articles">
            @foreach($list->articles as $article)
                <div class="gift-list-article">
                    <div class="image-box">
                        <img src="{{ $article->titleImage('thumb') }}" alt="{{ $article->title }}">
                    </div>
                    <div class="details">
                        <p class="title">{{ $article->title }}</p>
                        <p>{{ $article->intro }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection