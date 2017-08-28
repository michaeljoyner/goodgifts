@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Incoming Requests</h1>
        <div class="page-actions">

        </div>
    </header>
    <section class="list-request-section">
        <div class="data-list-strip">
            <div>
                <p class="label-text">Last 7 Days</p>
                <p class="value-text">{{ $counts['week'] }}</p>
            </div>
            <div>
                <p class="label-text">Last 30 Days</p>
                <p class="value-text">{{ $counts['month'] }}</p>
            </div>
            <div>
                <p class="label-text">Last 90 Days</p>
                <p class="value-text">{{ $counts['three_months'] }}</p>
            </div>
        </div>
    </section>
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
            </tr>
            </thead>
            <tbody>
            @foreach($signups as $signup)
                <tr>
                    <td>{{ $signup->sender }}</td>
                    <td>{{ $signup->recipient }}</td>
                    <td>{{ $signup->birthday->toFormattedDateString() }}</td>
                    <td>{{ $signup->interests }}</td>
                    <td>{{ $signup->sendDate() }}</td>
                    <td>{{ $signup->budget }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection