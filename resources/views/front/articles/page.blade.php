@extends('front.base')

@section('title')
{{ $article->title }}
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => $article->titleImage(),
        'ogTitle' => $article->title,
        'ogDescription' => $article->description
    ])
@endsection

@section('content')
    @include('front.partials.navbar')
    <article class="article-page-content">
        <h1 class="strong-font f2 f1-ns mh4 tc">{{ $article->title }}</h1>
        <div class="tc">
            <span class="col-p h1">@include('svgicons.calendar')</span>
            <p class="mv0 strong-font f6">{{ $article->lastUpdated()->toFormattedDateString() }}</p>
        </div>
        @include('front.partials.sharing_icons')
        <img src="{{ $article->titleImage('web') }}" class="db w-100 mw-800 center mv4" alt="{{ $article->title }}">
        <div class="mw-800 lh-title center-ns mh3 f6 f5-ns article-body">
            {!! $article->body !!}
        </div>
        @include('front.partials.sharing_icons')
    </article>
@endsection

@section('bodyscripts')
    @include('front.partials.article_structured_data')
@endsection