<div class="master-profile">
    <div class="master-photo">
        <img src='{{ $master->photo_url }}' class="master-photo">
        @if (count($master->reviews) > 0)
            <div style='text-align: center; margin-top: 10px'>
                <a class="tutors-item-reviews-toggle"
                    title="отзывы" ng-click='reviews_block = true'>отзывы ({{ count($master->reviews) }})</a>
            </div>
        @endif
    </div>
    <div>
        <b class="master-name">{{ implode(' ', [$master->last_name, $master->first_name, $master->middle_name]) }}</b>
        <div class="master-desc">{{ $master->description }}</div>
    </div>
</div>

<div style='margin: 40px 0 60px' ng-show='reviews_block'>
    {!! $reviewsBlock !!}
</div>
