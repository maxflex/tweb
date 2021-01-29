<div class="full-width-wrapper banner-block-full-width-wrapper {{ $args->align }}">
    <div class="common" style='position: relative'>
        <div class="full-width-wrapper banner-block {{ $args->align }}">
            <div class="banner-block__image" ng-style="{'background-image': 'url({{ $args->img }})'}"></div>
            <div class="info">
                <div class='info__items'>
                    <div>
                        {!! $h1 !!}
                    </div>
                    <div class='lines'>
                        @foreach ($lines as $line)
                        <div class='line'>
                            <i class="fas fa-check"></i>
                            <span>{{ $line }}</span>
                        </div>
                        @endforeach
                    </div>
                    <!--<a onclick="eventUrl('[link|376]', 'stat-count-price', 'banner')" class="btn-fill btn-calc">-->
                    <!--  <div class="flex-items">-->
                    <!--        <img src="/img/svg/calculator.svg">-->
                    <!--        <span>рассчитать стоимость моего ремонта</span>-->
                    <!--  </div>-->
                    <!--</a>-->
                </div>
            </div>
            <div class="gradient"></div>
        </div>
    </div>
</div>
