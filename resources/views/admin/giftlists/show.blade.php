@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Gift List #{{ $list->id }}</h1>
        <div class="page-actions">
            @if(! $list->approved)
            <form action="/admin/giftlists/{{ $list->id }}/approved" method="POST">
                {!! csrf_field() !!}
                <button class="gg-btn btn">Approve it!</button>
            </form>
            @endif
        </div>
    </header>
    <section class="list-request-section">
        <div class="data-list-strip">
            <div>
                <p class="label-text">Due date</p>
                <p class="value-text">{{ $list->request->sendDate() }}</p>
            </div>
            <div>
                <p class="label-text">Birthday</p>
                <p class="value-text">{{ $list->request->birthday->toFormattedDateString() }}</p>
            </div>
            <div>
                <p class="label-text">Budget</p>
                <p class="value-text">{{ $list->request->budgetLimit() }}</p>
            </div>
        </div>
        <div class="data-list-strip">
            <div>
                <p class="label-text">Requested By</p>
                <p class="value-text">{{ $list->request->sender }}</p>
            </div>
            <div>
                <p class="label-text">Requested For</p>
                <p class="value-text">{{ $list->request->recipient }}</p>
            </div>
            <div>
                <p class="label-text">Age</p>
                <p class="value-text">{{ $list->request->ageRange() }}</p>
            </div>
        </div>
    </section>
    <div class="mentioned-interests">
        <p class="label-text">Mentioned Interests</p>
        <p class="lead">{{ $list->request->interests }}</p>
    </div>
    <list-maker list-id="{{ $list->id }}"
                :default-suggestions='{{ json_encode($list->defaultSuggestions()->toArray()) }}'
                :current-list='{{ json_encode($list->suggestionList()) }}'
    ></list-maker>
    <list-writeup sender="{{ $list->request->sender ?: 'this fella' }}"
                  list-id="{{ $list->id }}"
                  initial-text="{{ $list->writeup }}"
    ></list-writeup>
    <giftlist-articles :articles="{{ json_encode($articles->toArray()) }}"
                       :initial-articles="{{ json_encode($list->articles->toArray()) }}"
                       list-id="{{ $list->id }}"
    ></giftlist-articles>
@endsection