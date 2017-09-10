<table class="table table-responsive">
    <thead>
    <tr>
        <th>#</th>
        <th>Due By</th>
        <th>Requested By</th>
        <th>Prod/Article/Text/Top Picks</th>
        <th>Go go go</th>
        <th>Approved</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list_of_lists as $list)
        <tr>
            <td>{{ $list->id }}</td>
            <td>{{ $list->request->sendDate() }}</td>
            <td>{{ $list->request->sender }}</td>
            <td>
                @if($list->suggestions->count() > 8)
                    @include('svgicons.mood-happy-solid')
                @else
                    @include('svgicons.mood-sad-solid')
                @endif
                @if($list->articles->count() > 1)
                    @include('svgicons.mood-happy-solid')
                @else
                    @include('svgicons.mood-sad-solid')
                @endif
                @if($list->writeup)
                    @include('svgicons.mood-happy-solid')
                @else
                    @include('svgicons.mood-sad-solid')
                @endif
                    @if($list->topPickCount() > 3)
                        @include('svgicons.mood-happy-solid')
                    @else
                        @include('svgicons.mood-sad-solid')
                    @endif
            </td>
            <td>
                <a href="/admin/giftlists/{{ $list->id }}" class="btn gg-btn">Work it</a>
            </td>
            <td>
                @if($list->approved)
                    @include('svgicons.checkmark')
                @endif
            </td>
            <td>
                @if($list->approved)
                    <a href="/lists/{{ $list->slug }}" class="btn gg-btn">Check it</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>