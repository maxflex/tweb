<div class='header-1'>
    {{ $title }}
    @if ($nobutton !== true)
        <a href='/price/' class="btn-border btn-small">полный прайс лист</a>
    @endif
</div>
<div class="price-wrapper">
    <div class="price-list">
        <ul>
            @foreach ($items as $item)
                <li>
                    <div class='price-item price-item-root'>
                        @include('price-item', ['item' => $item])
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
