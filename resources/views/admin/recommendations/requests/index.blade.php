@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">New Gift List Requests</h1>
        <div class="page-actions">

        </div>
    </header>
    <section class="recommendation-requests-list">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>Giftee</th>
                <th>Next Birthday</th>
                <th>Interests</th>
                <th>Send time</th>
                <th>Budget</th>
                <th>Make List</th>
            </tr>
            </thead>
            <tbody>
            @foreach($signups->filter->isNew() as $signup)
                <tr>
                    <td>{{ $signup->sender }}</td>
                    <td>{{ $signup->recipient }}</td>
                    <td>{{ $signup->birthday->toFormattedDateString() }}</td>
                    <td>{{ $signup->interests }}</td>
                    <td>{{ $signup->sendDate() }}</td>
                    <td>{{ $signup->budget }}</td>
                    <td>
                        <form action="/admin/recommendations/{{ $signup->id }}/giftlists" method="POST">
                            {!! csrf_field() !!}
                            <button class="gg-btn btn" type="submit">Make List</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection