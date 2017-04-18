@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Possible alternatives</h1>
        <div class="page-actions">

        </div>
    </header>
    <similar-search itemid="{{ $product->itemid }}" :articles='{{ \GuzzleHttp\json_encode($product->articles) }}'></similar-search>
@endsection