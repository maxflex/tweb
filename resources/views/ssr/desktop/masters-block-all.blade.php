<div class='header-1'>{{ $title }}</div>

<div class="full-width-wrapper" style='margin-top: 30px' ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    <div class="common main-page-masters masters-count-{{ count($items) }} masters-all">
        @foreach ($items as $index => $item)
        <div ng-hide='options.show <= {{ $index }}'>
            <div>
                <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                    <img src='{{ $item->photo_url }}' class="master-photo pointer">
                </a>
            </div>
            <b class="pointer master-name">
                <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                    {{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}
                </a>
            </b>
            <span>{{ $item->description }} <a href='/masters/{{ $item->id }}/'>Подробнее...</a></span>
        </div>
        @endforeach
    </div>

    @if ($options['show'] < count($items))
        <center ng-show='options.show < {{ count($items) }}' style='margin: 5px 0 10px'>
            <button class="btn-border" ng-click="options.show = options.show + 6">показать ещё</button>
        </center>
    @endif
</div>
