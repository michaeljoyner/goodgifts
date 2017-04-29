@extends('admin.base')

@section('head')
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <style>
        .article-poster-picture-maker {
            position: relative;
            width: 1200px;
        }

        .article-poster-picture-maker h1 {
            font-family: 'Fredoka One';
            font-size: 70px;
            padding: 0 15px;
            position: absolute;
            color: rgb(222,131,10);
            line-height: 1.4;
            background: rgba(46,40,40,0.8);
            bottom: 15px;
            left: 30px;
        }

        .article-poster-picture-maker img {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Make me a poster pic</h1>
        <div class="page-actions">
            <a href="/admin/articles/{{ $article->id }}" class="btn">Back</a>
        </div>
    </header>
    <section class="article-poster-picture-maker">
        <h1>{{ $article->title }}</h1>
        <img src="{{ $article->titleImage() }}" alt="">
    </section>
    <a href="{{ $article->titleImage() }}" class="btn" download="">Get Image</a>
@endsection