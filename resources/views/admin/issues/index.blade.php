@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Issues</h1>
        <div class="page-actions">

        </div>
    </header>
    <section class="issues-table-section">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>Date</th>
                <th>Issue Type</th>
                <th>Message</th>
            </tr>
            </thead>
            <tbody>
            @foreach($issues as $issue)
                <tr>
                    <td>{{ $issue->created_at->diffForHumans() }}</td>
                    <td><a href="/admin/issues/{{ $issue->id }}">{{ $issue->issue_type }}</a></td>
                    <td>{{ $issue->message }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection