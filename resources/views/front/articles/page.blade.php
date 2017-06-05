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
    @include('front.partials.standardheader')
    <article class="article-page-content">
        <h1 class="article-page-title">{{ $article->title }}</h1>
        <p class="article-date"><span>@include('svgicons.calendar')</span><br>{{ $article->lastUpdated()->toFormattedDateString() }}</p>
        @include('front.partials.sharing_icons')
        <img src="{{ $article->titleImage('web') }}" class="article-title-image" alt="{{ $article->title }}">
        <div class="article-body">
            {!! $article->body !!}
        </div>
        @include('front.partials.sharing_icons')
    </article>
@endsection

@section('bodyscripts')
    @include('front.partials.article_structured_data')
@endsection