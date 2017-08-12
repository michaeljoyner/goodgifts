@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Lists Under Construction</h1>
        <div class="page-actions">

        </div>
    </header>
    <section class="recommendation-requests-list">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Due By</th>
                <th>Requested By</th>
                <th>For</th>
                <th>Current Item Count</th>
                <th>Go go go</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lists as $list)
                <tr>
                    <td>{{ $list->id }}</td>
                    <td>{{ $list->request->sendDate() }}</td>
                    <td>{{ $list->request->sender }}</td>
                    <td>{{ $list->request->recipient }}</td>
                    <td>{{ $list->suggestions->count() }}</td>
                    <td>
                        <a href="/admin/giftlists/{{ $list->id }}" class="btn gg-btn">Work it</a>
                    </td>
                    <td>
                        @if($list->approved)
                        <a href="/lists/{{ $list->slug }}" class="btn gg-btn">Check it</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection