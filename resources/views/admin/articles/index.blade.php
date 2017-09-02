@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Articles</h1>
        <div class="page-actions">
            <button type="button" class="btn" data-toggle="modal" data-target="#create-article-modal">
                New Article
            </button>
        </div>
    </header>
    <section class="articles-index-list">
        <ul class="list-group">
            @foreach($articles as $article)
            <li class="list-group-item clearfix">
                <a href="/admin/articles/{{ $article->id }}">{{ $article->title }}</a>
                <span class="pull-right">Gifts For {{ $article->target }}</span>
            </li>
            @endforeach
        </ul>
        {!! $articles->links() !!}
    </section>
    @include('admin.forms.modals.article')
@endsection