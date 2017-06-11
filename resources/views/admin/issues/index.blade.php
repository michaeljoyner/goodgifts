@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Issues</h1>
        <div class="page-actions">

        </div>
    </header>
    <section class="issues-table-section">
        @if($issues->count() < 1)
            <p class="lead">There are no issues to report</p>
        @else
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Date</th>
                <th>Issue Type</th>
                <th>Product</th>
            </tr>
            </thead>
            <tbody>
            @foreach($issues as $issue)
                <tr>
                    <td>{{ $issue->created_at->diffForHumans() }}</td>
                    <td><a href="/admin/issues/{{ $issue->id }}">{{ class_basename($issue->issue_type) }}</a></td>
                    <td>
                        @if($issue instanceof \App\Issues\UnavailableProductIssue)
                            <img src="{{ $issue->issue->product->image }}" alt="" height="50px">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </section>
@endsection