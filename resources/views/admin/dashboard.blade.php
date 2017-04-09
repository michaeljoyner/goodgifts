@extends('admin.base')

@section('content')
    <h1>Some mutha-fuckin' stats</h1>
    <h3>Total Visitors and Page Views for last 12 Months</h3>
    <line-chart></line-chart>
    <h3>Most Viewed Pages For the Last 12 Months</h3>
    <ol class="list-group">
        @foreach($topPages as $page)
        <li class="list-group-item"><span>{{ $page['pageTitle'] }}</span> {{ $page['pageViews'] }} views</li>
        @endforeach
    </ol>
@endsection