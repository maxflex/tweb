@if ($item->is_link)
    @if(!in_array($item->id, [868, 869, 870]))
    <li class='menu-link-mobile'>
        <a class='menu-level-{{ $level + 1 }}' href='{{ $item->extra }}'>{{ $item->title }}</a>
    </li>
    @else
    <li class='menu-link-mobile menu-link-mobile--with-metro'>
        <div>
            <a class='menu-level-{{ $level + 1 }}' href='{{ $item->extra }}'>{{ $item->title }}</a>

            @if($item->id === 868)
            <div class='menu-addr'>
                <i class="fas fa-map-marker-alt"></i>
                {{ $maps['len']['address'] }}
            </div>
            <div class='menu-metros'>
                <div class='flex-items-center'>
                    <span class='metro-circle line-5'></span>
                    <span>Октябрьская</span>
                </div>
                <div class='flex-items-center'>
                    <span class='metro-circle line-6'></span>
                    <span>Ленинский проспект</span>
                </div>
                <div class='flex-items-center'>
                    <span class='metro-circle line-6'></span>
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
                    <span class='metro-circle line-7'></span>
                    <span>Полежаевская</span>
                </div>
                <div class='flex-items-center'>
                    <span class='metro-circle line-8'></span>
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
                    <span class='metro-circle line-9'></span>
                    <span>Цветной бульвар</span>
                </div>
                <div class='flex-items-center'>
                    <span class='metro-circle line-10'></span>
                    <span>Достоевская</span>
                </div>
                <div class='flex-items-center'>
                    <span class='metro-circle line-9'></span>
                    <span>Менделеевская</span>
                </div>
                <div class='flex-items-center'>
                    <span class='metro-circle line-5'></span>
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
