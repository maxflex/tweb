<div class="service-list" ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    {{-- FIRST ITEM --}}
    @if ($firstItem)
        <div class="service-list_one-line">
            @if ($firstItem->title)
                @if ($firstItem->link_url)
                    <a class='no-style-link' href='/{{ $firstItem->link_url }}/'>
                        <div class='header-3'>{{ $firstItem->title }}</div>
                    </a>
                @else
                    <div class='header-3'>{{ $firstItem->title }}</div>
                @endif
            @endif

             <div style='margin-bottom: 15px'>
                {!! $firstItem->description !!}
             </div>

            <center ng-hide='options.showAllItems'>
                <button class="btn-border" ng-click="options.showAllItems = true" style='margin-top: 15px'>
                    дополнительные услуги
                </button>
            </center>
        </div>
    @endif

    {{-- OTHER ITEMS --}}
    @if ($noIcons)
        <div class='expander'>
            <div class='expander__item'>
                <!-- ПУНКТ МЕНЮ 1-->
                @foreach ($items as $index => $item)
                <ul style='border-bottom: none'>
                    <li>
                        <div class='price-item price-item-root'>
                            <div class="price-line price-section" onclick="togglePrice(event)">
                                <span class="price-line-title">{{ $item->title }}</span>
                                <img src="/img/svg/pricelist-arrow.svg">
                            </div>
                            <ul class='hidden'>
                                <li class='price-line' style='font-size: 16px; line-height: 26px'>
                                    {!! $item->description !!}
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                @endforeach
            </div>
        </div>
    @else
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
            <center ng-show='options.show < {{ count($items) }}'>
                <button class="btn-border" ng-click="options.show = options.show + 6">
                    {{ $firstItem ? 'дополнительные услуги' : 'показать ещё' }}
                </button>
            </center>
        @endif
    </div>
    @endif
</div>

@if ($noIcons)
<div style='height: 40px'></div>
@else
<div class='block-separator block-separator_with-margins'></div>
@endif
