@if ($isFullPrice)
    <h1 class='h1-top'>Прайс-лист</h1>
@else
<div class='header-1'>
    <h2 style="font-size: 28px; font-family: 'helveticaneuecyrregular';">Прайс-лист</h2>

    @if ($nobutton !== true)
	    <center style='margin: 15px 0 0'>
	        <a href='/price/' class='no-style-link'>
	            <button class="btn-border">полный прайс-лист</button>
	        </a>
	    </center>
	@endif

    {{-- @if ($nobutton !== true)
        <div style="margin-bottom: 25px; color: #960000">
            <i class="fas fa-align-left" style="margin-right: 3px; font-size: 12px"></i>
            <a href="/price/">полный прайс-лист</a>
        </div>
    @endif --}}
</div>
@endif


<div class="price-wrapper">
    <div class="price-list" itemprop="offers" itemscope itemtype="//schema.org/AggregateOffer">
        <ul>
            @foreach ($items as $item)
                <li>
                    <div class='price-item price-item-root'>
                        @include('price-item', ['item' => $item])
                    </div>
                </li>
            @endforeach
        </ul>
        <meta itemprop="lowPrice" content="{{ $lowPrice  }}" />
        <meta itemprop="highPrice" content="{{ $maxPrice  }}" />
        <meta itemprop="offerCount" content="{{ $offerCount  }}" />
        <meta itemprop="priceCurrency" content="рублей"/>
    </div>

</div>
