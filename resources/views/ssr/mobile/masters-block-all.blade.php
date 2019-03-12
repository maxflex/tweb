<div class="full-width gray-full-width" style='margin-bottom: 60px' ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    <div class="common" style='display: inline-block'>
        <div class='header-1' style='padding-bottom: 30px'>{{ $title }}</div>
        <div class="main-page-masters">
            @foreach ($items as $index => $item)
            <div ng-hide='options.show <= {{ $index }}'>
                <div>
                    <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                        <img src='{{ $item->photo_url }}' class="master-photo">
                    </a>
                </div>
                <div>
                    <div class="master-name">
                        <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                            {{ $item->first_name }}
                            {{ $item->middle_name }}
                            {{ $item->last_name }}
                        </a>
                    </div>
                    <div class="masters-description">
                        {{ $item->description_short }} <a href='/masters/{{ $item->id }}/'>Подробнее...</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if ($options['show'] < count($items))
        <center ng-show='options.show < {{ count($items) }}'  style='margin: 5px 0 10px'>
            <button class="btn-border" ng-click="options.show = options.show + options.showBy">показать ещё</button>
        </center>
        @endif
    </div>
</div>
