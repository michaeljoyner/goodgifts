@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Issues</h1>
        <div class="page-actions">
            @include('admin.partials.deletebutton', [
                'objectName' => $issue->isue_type,
                'deleteFormAction' => '/admin/issues/' . $issue->id
            ])
        </div>
    </header>
    <section>
        <p class="lead">{{ $issue->message }}</p>
    </section>
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection