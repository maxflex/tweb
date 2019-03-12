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
                    @if (count($master->reviews) > 0)
                    <li>
                        <a class="popup-show" ng-click="popup('reviews', master, 'reviews', $index)"
                            data-popup="popup__masters-reviews">отзывы</a> ({{ count($master->reviews) }})
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- отзывы -->
<div class='modal' id='modal-reviews'>
    <div class='modal-button modal-button-top' onclick='closeModal()'></div>
    <div class='modal-content'>
        {!! $reviewsBlock !!}
    </div>
</div>
<!-- /отзывы -->
