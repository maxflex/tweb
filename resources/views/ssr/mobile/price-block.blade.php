@if ($isFullPrice)
    <h1 class='h1-top'>Прайс-лист</h1>
@else
    <div class='header-1'>Прайс-лист</div>
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
    </div>
    @if (! $isFullPrice)
    <center class='more-button'>
        <a href='/order/' class="btn-fill btn-calc">
          <div class="flex-items">
                <img src="/img/svg/calculator.svg">
                <span>расчитать стоимость моего ремонта</span>
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
