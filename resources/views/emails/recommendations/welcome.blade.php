@component('mail::message')
## You just did some very dangerous

Hey {{ $request->sender }}, are you aware of what you have done?

You went ahead and asked goodgiftsforguys.com to send you a custom gift list for {{ $request->recipient }} on the {{ $request->birthday->subMonth()->toFormattedDateString() }}, which is one month before his birthday.


@endcomponent