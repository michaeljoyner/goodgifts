@component('mail::message')
##

{{ $list->intro }}

Here is a little taster of his list. An aperitif, if you will.

@foreach($list->topPicks()->take(3) as $pick)
@component('mail::panel')
    **What**: {{ $pick->suggestion->what }}<br>
    **Why**: {{ $pick->suggestion->why }}<br>
@endcomponent
@endforeach

Just hit the link below to get see the full list, along with actual products, links, prices and more. It couldn't be easier.

@component('mail::button', ['url' => url('/lists/' . $list->slug)])
    Check your List
@endcomponent

Thanks again for getting in touch. If you like what we do, maybe give us a little shout out on Facebook, Instagram, or just scream it from the top of a mountain. We'd really appreciate it.

Never stop being you.

Have a great day!
Goodgiftsforguys.com


[Unsubscribe]({{ url('/lists/unsubscribe/' . $list->request->unsubscribe_token) }})
@endcomponent
