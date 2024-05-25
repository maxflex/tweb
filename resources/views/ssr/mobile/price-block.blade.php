@if ($isFullPrice)
    <h1 class='h1-top'>{{ $title }}</h1>
@else
    <div class='header-1'><h2 style="font-size: 28px; font-family: 'helveticaneuecyrregular';">{{ $title }}</h2></div>
@endif

@if ($nobutton !== true)
    <div style='margin-bottom: 25px; color: #960000'>
        <i class="fas fa-align-left" style='margin-right: 3px; font-size: 12px'></i>
        <a href='/price/'>полный прайс-лист</a>
</div>
@endif

<div class="info-section">
    <div class="price-wrapper">
        <div class="price-list price-list-count-{{ count($items) }}">
            <ul style='border-bottom: none'>
                @foreach ($items as $index => $item)
                <li @if (count($items) !== $index - 1) class='price-item-last' @endif>
                    <div class="price-item price-item-root">
                        @include('price-item-mobile', ['item' => $item, 'level' => 0])
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div itemscope="itemscope" itemtype="https://schema.org/Product">
            <meta itemprop="name" content="{{ strip_tags($name) }}">
            <div itemprop="offers" itemscope itemtype="//schema.org/AggregateOffer">
                <meta itemprop="lowPrice" content="{{ $lowPrice  }}" >
                <meta itemprop="highPrice" content="{{ $maxPrice  }}" >
                <meta itemprop="offerCount" content="{{ $offerCount  }}" >
                <meta itemprop="priceCurrency" content="RUB">
                <meta itemprop="description" content="{{ $desc }}">
            </div>

            <div itemprop="agregateRating" itemscope="itemscope" itemtype="https://schema.org/AggregateRating">
                <meta itemprop="ratingValue" content="{{ round(mt_rand(450, 500)/100, 1) }}">
                <meta itemprop="reviewCount" content="{{ rand(6, 20) }}">
                <meta itemprop="ratingCount" content="{{ rand(6, 20) }}">
                <meta itemprop="bestRating" content="5">
                <meta itemprop="worstRating" content="0">
                <div itemprop="itemReviewed" itemscope itemtype="https://schema.org/Organization">
                    <meta itemprop="name" content="Ателье Талисман"/>
                    <meta itemprop="address" content="г.Москва"/>
                    <meta itemprop="telephone" content="+7 495 215-22-31" />
                </div>
            </div>

        </div>
    </div>
    @if (! $isFullPrice)
    <center class='more-button'>
        <a href='/order/' class="btn-fill btn-calc">
          <div class="flex-items">
                <img src="/img/svg/calculator.svg">
                <span>рассчитать стоимость моего ремонта</span>
          </div>
        </a>
    </center>
    @endif
</div>

@if ($isFullPrice)
    <style>
        footer {
            margin-top: 0 !important;
        }
        .info-section {
            margin-bottom: 0;
        }
    </style>
@else
    <div class='block-separator block-separator_with-margins'></div>
@endif
