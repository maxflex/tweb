@if ($isFullPrice)
    <h1 class='h1-top'>{{ $title }}</h1>
@else
<div class='header-1'>
    {{ $title }}
    @if ($nobutton !== true)
        <a href='/price/' class="btn-border btn-small">полный прайс лист</a>
    @endif
</div>
@endif

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
