@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Search For Cards</h1>
        <div class="page-actions">
            <a href="/admin/cards" class="btn">View Our Cards</a>
        </div>
    </header>
    <card-search></card-search>
@endsection