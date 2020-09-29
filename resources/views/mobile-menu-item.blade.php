@if ($item->is_link)
    @if(!in_array($item->id, [868, 869, 870, 963]))
    <li class='menu-link-mobile'>
        <a class='menu-level-{{ $level + 1 }}' href='{{ $item->extra }}'>{{ $item->title }}</a>
    </li>
    @else
    <li class='menu-link-mobile menu-link-mobile--with-metro'>
        <div>
            <a class='menu-level-{{ $level + 1 }}' href='{{ $item->extra }}'>{{ $item->title }}</a>

            @if($item->id === 963)
                @foreach($maps as $map)
                <div class='menu-addr'>
                    <div class="fas fa-map-marker-alt"></div>
                    {{ $map['address'] }}
                </div>
                @endforeach
                <div class="menu-metros"></div>
            @endif


        @if($item->id === 868)
        <div class='menu-addr'>
            <i class="fas fa-map-marker-alt"></i>
            {{ $maps['len']['address'] }}
        </div>
        <div class='menu-metros'>
            <div class='flex-items-center'>
                <img src="/img/svg/metro/black/line-5.svg" class='metro-svg'></img>
                <span>Октябрьская</span>
            </div>
            <div class='flex-items-center'>
            <img src="/img/svg/metro/black/line-6.svg" class='metro-svg'></img>
            <span>Ленинский проспект</span>
        </div>
        <div class='flex-items-center'>
            <img src="/img/svg/metro/black/line-6.svg" class='metro-svg'></img>
            <span>Шаболовская</span>
            </div>
            </div>
            @endif

            @if($item->id === 869)
            <div class='menu-addr'>
                <i class="fas fa-map-marker-alt"></i>
                {{ $maps['pol']['address'] }}
            </div>
            <div class='menu-metros'>
                <div class='flex-items-center'>
                    <img src="/img/svg/metro/black/line-7.svg" class='metro-svg'></img>
                    <span>Полежаевская</span>
                </div>
                <div class='flex-items-center'>
                    <img src="/img/svg/metro/black/line-8.svg" class='metro-svg'></img>
                    <span>Хорошевская</span>
                </div>
            </div>
            @endif

            @if($item->id === 870)
            <div class='menu-addr'>
                <i class="fas fa-map-marker-alt"></i>
                {{ $maps['delegat']['address'] }}
            </div>
            <div class='menu-metros'>
                <div class='flex-items-center'>
                    <img src="/img/svg/metro/black/line-9.svg" class='metro-svg'></img>
                    <span>Цветной бульвар</span>
                </div>
                <div class='flex-items-center'>
                    <img src="/img/svg/metro/black/line-10.svg" class='metro-svg'></img>
                    <span>Достоевская</span>
                </div>
                <div class='flex-items-center'>
                    <img src="/img/svg/metro/black/line-9.svg" class='metro-svg'></img>
                    <span>Менделеевская</span>
                </div>
                <div class='flex-items-center'>
                    <img src="/img/svg/metro/black/line-5.svg" class='metro-svg'></img>
                    <span>Новослободская</span>
                </div>
            </div>
            @endif
        </div>
    </li>
    @endif
@else
<li>
    <div class='price-item {{ $level === 0 ? 'price-item-root' : 'price-item-section' }}'>
        <div class="price-line price-section" onclick="togglePrice(event, true)">
            <span class="price-line-title menu-level-{{ $level }}">{{ $item->title }}</span>
            <span class="price-section-desc menu-level-{{ $level }}">{{ $item->extra }}</span>
            <img src="/img/svg/pricelist-arrow.svg">
        </div>
        @if (count($item->children) > 0)
            <ul class='hidden'>
                @foreach ($item->children as $child)
                    @include('mobile-menu-item', ['item' => $child, 'level' => $level + 1])
                @endforeach
            </ul>
        @endif
    </div>
</li>
@endif
