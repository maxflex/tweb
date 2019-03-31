@if ($isFullPrice)
    <h1 class='h1-top'>{{ $title }}</h1>
@else
<div class='header-1'>
    {{ $title }}
    {{-- @if ($nobutton !== true)
        <div style="margin-bottom: 25px; color: #960000">
            <i class="fas fa-align-left" style="margin-right: 3px; font-size: 12px"></i>
            <a href="/price/">полный прайс лист</a>
        </div>
    @endif --}}
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

@if ($nobutton !== true)
    <center class='more-button'>
        <a href='/price/' class='no-style-link'>
            <button class="btn-border">полный прайс лист</button>
        </a>
    </center>
@endif
