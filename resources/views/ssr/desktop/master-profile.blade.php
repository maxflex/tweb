<div class="master-profile">
    <div class="master-photo">
        <img src='{{ $master->photo_url }}' class="master-photo">
        @if ($master->reviews()->exists())
            <div style='text-align: center; margin-top: 10px'>
                <a class="tutors-item-reviews-toggle" title="отзывы" ng-click='reviews_block = true'>
                    отзывы ({{ $master->reviews()->count() }})
                </a>
            </div>
        @endif
    </div>
    <div>
        <h1 class="master-name">{{ implode(' ', [$master->last_name, $master->first_name, $master->middle_name]) }}</h1>
        <div class="master-desc">{{ $master->description }}</div>
    </div>
</div>
