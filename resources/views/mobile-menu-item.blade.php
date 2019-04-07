@if ($item->is_link)
<li class='menu-link-mobile'>
    <a class='menu-level-{{ $level + 1 }}' href='{{ $item->extra }}'>{{ $item->title }}</a>
</li>
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
