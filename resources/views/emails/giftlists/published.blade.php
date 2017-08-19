@component('mail::message')
# Introduction

{{ $list->writeup }}

@component('mail::button', ['url' => url('/lists/' . $list->slug)])
Check your List
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
