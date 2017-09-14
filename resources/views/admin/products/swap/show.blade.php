@extends('admin.base')

@section('content')

    <product-swap :original="{{ json_encode($product->toArray()) }}"
                  :original-tags="{{ json_encode($product->tags->pluck('tag')->all()) }}"
                  :suggestions="{{ json_encode($product->suggestions()->with('article')->get()->toArray()) }}"
    ></product-swap>
@endsection