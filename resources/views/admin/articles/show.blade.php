@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">{{ $article->title }}</h1>
        <div class="page-actions">
            <a href="/admin/articles/{{ $article->id }}/edit" class="btn">Edit Info</a>
        </div>
    </header>
    <section class="article-show">
        <div class="row">
            <div class="col-md-6">
                <div class="article-overview">
                    <p><strong>Published: </strong>{{ $article->published ? 'Yes' : 'No' }}</p>
                    <p><strong>Publish Date: </strong>{{ $article->published_on ? $article->published_on->toFormattedDateString() : 'Never Published'}}</p>
                    <p><strong>Last Updated: </strong>{{ $article->updated_at->toFormattedDateString() }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <article-publisher
                        :initial-state="{{ $article->published ? 'true' : 'false' }}"
                        :article-id="{{ $article->id }}"
                        published-on="{{ $article->published_on ? $article->published_on->format('Y-m-d') : '' }}"
                ></article-publisher>
            </div>
        </div>

        <p class="article-description lead">{{ $article->description }}</p>

    </section>
@endsection