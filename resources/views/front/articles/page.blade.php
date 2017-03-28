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
    <header class="page-header">
        <a href="/">
            <h1 class="page-title">Good Gifts <span>For guys</span></h1>
        </a>
    </header>
    <article class="article-page-content">
        <h1 class="article-page-title">{{ $article->title }}</h1>
        <p class="article-date"><span>@include('svgicons.calendar')</span>{{ $article->updated_at->toFormattedDateString() }}</p>
        <img src="{{ $article->titleImage('web') }}" class="article-title-image" alt="{{ $article->title }}">
        <div class="article-body">
            {!! $article->body !!}
        </div>
    </article>
@endsection