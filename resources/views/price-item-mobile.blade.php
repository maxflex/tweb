<div class="price-line price-{{ $item['is_section'] ? 'section' : 'position' }}" onclick="togglePrice(event)">
    <span class="price-line-title menu-level-{{ $level }}">{{ $item['model']['name'] }}</span>
    @if (! $item['is_section'] && $item['model']['price'])
        <span class="price-item-info menu-level-{{ $level }}">
            от <span class="price-item-price">{{ $item['model']['price'] }}</span> руб.
            @if (@$item['model']['unit'])
                <span>/ {{ $item['model']['unit'] }}</span>
            @endif
        </span>
    @endif
    @if ($item['is_section'] && $item['model']['extra_column'])
        <span class="price-section-desc menu-level-{{ $level }}">
            {{ $item['model']['extra_column'] }}
        </span>
    @endif
    @if ($item['is_section'] && (isset($item['items']) && count($item['items']) > 0))
        <img src="/img/svg/pricelist-arrow.svg">
    @endif
</div>

@if (isset($item['items']) && count($item['items']))
<ul class="hidden">
    @foreach ($item['items'] as $childItem)
    <li class="price-item-{{ $childItem['is_section'] ? 'section' : 'position' }}">
        <div class='price-item'>
            @include('price-item-mobile', ['item' => $childItem, 'level' => $level + 1])
        </div>
    </li>
    @endforeach
</ul>
@endif
