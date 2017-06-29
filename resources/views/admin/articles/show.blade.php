@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">{{ $article->title }}</h1>
        <div class="page-actions">
            <a href="/admin/articles/{{ $article->id }}/products/app" class="btn">Products</a>
            <a href="/admin/articles/{{ $article->id }}/edit" class="btn">Edit Info</a>
            <a href="/admin/articles/{{ $article->id }}/body/edit" class="btn">Edit Article</a>
            <a href="/admin/articles/{{ $article->id }}/preview" class="btn" target="_blank">Preview</a>
            <a href="/admin/articles/{{ $article->id }}/poster" class="btn">Poster</a>
        </div>
    </header>
    <section class="article-show">
        <div class="row">
            <div class="col-md-7">
                <div class="article-overview">
                    <p><strong>Published: </strong>{{ $article->published ? 'Yes' : 'No' }}</p>
                    <p><strong>Publish Date: </strong>{{ $article->published_on ? $article->published_on->toFormattedDateString() : 'Never Published'}}</p>
                    <p><strong>Last Updated: </strong>{{ $article->updated_at->toFormattedDateString() }}</p>
                </div>
                <p class="small-heading">SEO Description</p>
                <p class="article-description lead">{{ $article->description }}</p>
                <p class="small-heading">Intro</p>
                <p class="lead">{{ $article->intro }}</p>
            </div>
            <div class="col-md-5 text-center">
                <div class="single-image-uploader-box">
                    <p>Set the Article Image:</p>
                    <single-upload default="{{ $article->titleImage('web') }}"
                                   url="/admin/articles/{{ $article->id }}/titleimage"
                                   shape="square"
                                   size="preview"
                                   :preview-width="320"
                                   :preview-height="180"
                    ></single-upload>
                </div>
                <article-publisher
                        :initial-state="{{ $article->published ? 'true' : 'false' }}"
                        :article-id="{{ $article->id }}"
                        published-on="{{ $article->published_on ? $article->published_on->format('Y-m-d') : '' }}"
                ></article-publisher>
            </div>
        </div>
        <tag-repository></tag-repository>
        <item-tagger
                sync-url="/admin/articles/{{ $article->id }}/interests"
                :initial-tags="{{ json_encode($article->interests->pluck('interest')->toArray()) }}"
                tag-type="article"
        ></item-tagger>
        {{--<div class="article-products-section">--}}
            {{--<article-products article-id="{{ $article->id }}"></article-products>--}}
        {{--</div>--}}
        <div class="article-products">
            @foreach($article->products as $product)
                <div class="article-product-tagging-card">
                    <div class="product-details">
                        <img src="{{ $product->image }}" alt="" width="80">
                        <p class="title">{{ $product->title }}</p>
                        <span class="price btn">{{ $product->price }}</span>
                        <a class="btn" href="{{ $product->link }}">On Amazon</a>
                    </div>
                    <div class="product-tag-box">
                        <item-tagger
                                sync-url="/admin/products/{{ $product->id }}/tags"
                                :initial-tags="{{ json_encode($product->tags->pluck('tag')->toArray()) }}"
                                tag-type="product"
                        ></item-tagger>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
@endsection