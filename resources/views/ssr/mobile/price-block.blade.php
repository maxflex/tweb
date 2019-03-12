@if ($nobutton !== true)
<div style='margin-bottom: 25px; color: #960000'>
    <i class="fas fa-align-left" style='margin-right: 3px; font-size: 12px'></i>
    <a href='/price/'>полный прайс лист</a>
</div>
@endif
<div class="info-section">
    <div class="price-wrapper">
        <div class="price-list">
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
    <center class='more-button'>
        <a href='/order/' class="btn-fill btn-calc">
          <div class="flex-items">
                <img src="/img/svg/calculator.svg">
                <span>расчитать стоимость моего ремонта</span>
          </div>
        </a>
    </center>
</div>
