@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Recommendation SignUps</h1>
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
            </tr>
            </thead>
            <tbody>
            @foreach($signups as $signup)
                <tr>
                    <td>{{ $signup->sender }}</td>
                    <td>{{ $signup->recipient }}</td>
                    <td>{{ $signup->birthday->toFormattedDateString() }}</td>
                    <td>{{ $signup->interests }}</td>
                    <td>{{ $signup->birthday->subMonth()->diffForHumans() }}</td>
                    <td>{{ $signup->budget }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection