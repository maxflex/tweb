<div class="service-list" ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    {{-- FIRST ITEM --}}
    @if ($firstItem)
        <div class="service-list__items service-list__items_one-line">
            <div style='width: 100%; display: flex; align-items: center;'>
                <div class='pointer'>
                    <a class='no-style-link' href='/{{ $firstItem->link_url }}/'>
                        <img src='{{ $firstItem->photo_url }}'>
                    </a>
                </div>
                <div>
                    @if ($firstItem->title)
                        <a class='no-style-link' href='/{{ $firstItem->link_url }}/'>
                            <div class='header-3 pointer'>{{ $firstItem->title }}</div>
                        </a>
                    @endif
                    <span class='service-list__item-description'>
                        {!! $firstItem->description !!}
                    </span>
                </div>
            </div>
            <center style="margin: 38px 0 0; width: 100%" ng-hide='options.showAllItems'>
                <button class="btn-border" ng-click="options.showAllItems = true">дополнительные услуги</button>
            </center>
        </div>
    @endif

    {{-- OTHER ITEMS --}}
    <div class="service-list__items {{ $firstItem ? 'service-list__items_after-one-line' : '' }}" ng-show='options.showAllItems'>
        @foreach ($items as $index => $item)
            <div ng-hide='options.show <= {{ $index }}'>
                <div class='pointer'>
                    <a class='no-style-link' href='/{{ $item->link_url }}/'>
                        <img src='{{ $item->photo_url }}'>
                    </a>
                </div>
                <div>
                    <a class='no-style-link' href='/{{ $item->link_url }}/'>
                        <div class='header-3 pointer'>{{ $item->title }}</div>
                    </a>
                    <span>
                        <span class="service-list__item-description">{!! $item->description !!}</span>
                        @if ($item->link_url)
                            <a href='/{{ $item->link_url }}/' class="link-small">подробнее...</a>
                        @endif
                    </span>
                </div>
            </div>
        @endforeach
        @if ($options['show'] < $options['count'])
            <center style="width: 100%; margin: 38px 0 0" ng-show='options.show < {{ count($items) }}'>
                <button class="btn-border" ng-click="options.show = options.show + 6">
                    показать ещё
                </button>
            </center>
        @endif
    </div>

</div>

