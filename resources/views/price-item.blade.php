<div class="price-line price-{{ $item['is_section'] ? 'section' : 'position' }} {{ (isset($item['items']) && count($item['items']) > 0) ? 'pointer' : '' }}"
    onclick='togglePrice(event)'>
    <span class="price-line-title">{{ $item['model']['name'] }}</span>
    @if (! $item['is_section'] && $item['model']['price'])
        <span class="price-item-info">
            от <span class="price-item-price">{{ $item['model']['price'] }}</span> руб.
            @if (@$item['model']['unit'])
                <span>/ {{ $item['model']['unit'] }}</span>
            @endif
        </span>
    @endif
    @if ($item['is_section'] && $item['model']['extra_column'])
        <span class="price-section-desc">
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
            {{-- <li class="price-item-@{{ $parent.$id }} price-item-@{{ item.is_section ? 'section' : 'position' }}"> --}}
            <li class="price-item-{{ $childItem['is_section'] ? 'section' : 'position' }}">
                <div class='price-item'>
                    @include('price-item', ['item' => $childItem])
                </div>
            </li>
        @endforeach
    </ul>
@endif
