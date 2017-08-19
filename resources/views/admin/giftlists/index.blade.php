@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Upcoming Gift Lists</h1>
        <div class="page-actions">

        </div>
    </header>
    <section class="list-request-section">
        <div class="data-list-strip">
            <div>
                <p class="label-text">Urgent Lists</p>
                <p class="value-text">{{ $urgent_lists->count() }}</p>
            </div>
            <div>
                <p class="label-text">Upcoming Lists</p>
                <p class="value-text">{{ $upcoming_lists->count() }}</p>
            </div>
            <div>
                <p class="label-text">Also in the queue</p>
                <p class="value-text">{{ $unlisted_count }}</p>
            </div>
        </div>
    </section>
    <section class="recommendation-requests-list">
        @if($urgent_lists->count())
            <div class="urgent-lists giftlist-table-section">
                <h3>Urgent, needs to be done ASAP</h3>
                @include('admin.giftlists.listtable', ['list_of_lists' => $urgent_lists])
            </div>
        @endif
        @if($upcoming_lists->count())
            <div class="urgent-lists giftlist-table-section">
                <h3>Upcoming in the next few weeks</h3>
                @include('admin.giftlists.listtable', ['list_of_lists' => $upcoming_lists])
            </div>
        @endif
    </section>
@endsection