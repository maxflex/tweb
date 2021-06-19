<div class="main-page-masters">
    <div>
        <div>
            <img src='{{ $master->photo_url }}' class="master-photo">
        </div>
        <div>
            <div class="master-name">
                {{ $master->first_name }}
                {{ $master->middle_name }}
                {{ $master->last_name }}
            </div>
            <div class="masters-description">
                {{ $master->description_short }}
            </div>
            <div style='margin-top: 10px'>
                <ul class="list-main">
                    @if ($master->reviews()->exists())
                    <li>
                        <a class="popup-show"
                            ng-click="popup('reviews', master, 'reviews', $index)"
                            data-popup="popup__masters-reviews"
                        >
                            отзывы
                        </a>
                        ({{ $master->reviews()->count() }})
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
