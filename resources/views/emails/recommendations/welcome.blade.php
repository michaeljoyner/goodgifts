@component('mail::message')
You just asked goodgiftsforguys.com to create a gift list for {{ $request->recipient }}, and we're already on the case. In fact, somebody just wrote {{ $request->whiteboard_word }} in the middle of the whiteboard and drew a circle around it, so we clearly mean business.

We’ll will be in touch again {{ $request->mail_date }} with the complete list, which means one less thing for you to worry about today.

Have a great day, {{ $request->sender }}.

goodgiftsforguys.com

[Unsubscribe]({{ url('/lists/unsubscribe/' . $request->unsubscribe_token) }})
@endcomponent