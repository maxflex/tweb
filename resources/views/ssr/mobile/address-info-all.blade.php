@foreach(['len', 'pol', 'delegat'] as $map)
    @include('ssr.mobile.address-info', [
        'info' => (object) getMapInfo($map)
    ])
@endforeach
