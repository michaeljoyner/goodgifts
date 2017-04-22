@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Our Card Collection</h1>
        <div class="page-actions">
            <a href="/admin/cards/search" class="btn">Find New Cards</a>
        </div>
    </header>
    <card-collection></card-collection>
@endsection