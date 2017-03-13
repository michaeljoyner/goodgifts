@extends('admin.base')

@section('head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

@endsection

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">{{ $article->title }}</h1>
        <div class="page-actions">
            <a href="/admin/articles/{{ $article->id }}" class="btn">Article Overview</a>
        </div>
    </header>

    <editor post-id="{{ $article->id }}"
            post-content='{{ $article->body }}'
    ></editor>
@endsection