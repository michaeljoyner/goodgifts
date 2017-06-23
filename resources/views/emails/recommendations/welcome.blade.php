@component('mail::message')
{{ $request->sender }}, you just asked goodgiftsforguys.com to create a gift list for {{ $request->recipient }}. And you better believe we're on the case. In fact, somebody just wrote "{{ $request->recipient }}" in the middle of the whiteboard and drew a circle around it, so you know it is serious.

I better get in there before those swines finish the donuts, but we will be in touch again on {{ $request->birthday->subMonth()->toFormattedDateString() }} with that list, so don't you worry a second longer.

Now go look at something that'll make you happy. You've earned it! I usually google sloths, or watch the chicken wears pants video, but that just me. Go on you beautiful creature!

Have a great day.

Much love,

The GoodGifts Guys
@endcomponent