@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Products: {{ $article->title }}</h1>
        <div class="page-actions">
            <a href="/admin/articles/{{ $article->id }}" class="btn">Back</a>
        </div>
    </header>
    <article-products-app article-id="{{ $article->id }}"></article-products-app>
@endsection