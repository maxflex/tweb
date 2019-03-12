<div class="service-list" ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    {{-- FIRST ITEM --}}
    @if ($firstItem)
        <div class="service-list_one-line">
            @if ($firstItem->title)
                <a class='no-style-link' href='/{{ $firstItem->link_url }}/'>
                    <div class='header-3'>{{ $firstItem->title }}</div>
                </a>
            @endif

             <div style='margin-bottom: 15px'>
                {!! $firstItem->description !!}
             </div>

            <center style="margin: 14px 0 50px; width: 100%" ng-hide='options.showAllItems'>
                <button class="btn-border" ng-click="options.showAllItems = true" style='margin-top: 15px'>
                    дополнительные услуги
                </button>
            </center>
        </div>
    @endif

    {{-- OTHER ITEMS --}}
    <div class="service-list__items {{ $firstItem ? 'service-list__items_after-one-line' : '' }}" ng-show='options.showAllItems'>
        @foreach ($items as $index => $item)
            <div ng-hide='options.show <= {{ $index }}'>
                @if ($item->link_url)
                    <div>
                        <a href='/{{ $item->link_url }}/'>
                            <img src='{{ $item->photo_url }}'>
                        </a>
                    </div>
                    <div class='header-3'>
                        <a href='/{{ $item->link_url }}/'>
                            {{ $item->title }}
                        </a>
                    </div>
                @else
                    <div>
                        <img src='{{ $item->photo_url }}'>
                    </div>
                    <div class='header-3'>
                        {{ $item->title }}
                    </div>
                @endif
            </div>
        @endforeach
        @if ($options['show'] < count($items))
            <center style="margin: 14px 0 50px; width: 100%" ng-show='options.show < {{ count($items) }}'>
                <button class="btn-border" ng-click="options.show = options.show + 6">
                    {{ $firstItem ? 'дополнительные услуги' : 'показать ещё' }}
                </button>
            </center>
        @endif
    </div>
</div>

