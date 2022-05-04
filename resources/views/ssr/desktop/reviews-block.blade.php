<div ng-if='true'>
    <div class="reviews-wrapper" ng-init="review.service.init({{ json_encode($args) }}, 'review', review.onLoaded)">
        @foreach ($data->items() as $item)
            <div class="student-review">
                <div class="student-review-photo"></div>
                <div class="student-review-text">
                    <div class="student-review-name">{{ $item->signature }}</div>
                    <div>
                        <span>{{ $item->body }}</span>
                        @if ($item->master)
                            <span>
                                Мастер:
                                    <a href='/masters/{{ $item->master->id }}/'>{{ $item->master->first_name }} {{ $item->master->middle_name }}</a>
                            </span>
                        @endif
                    </div>
                    <div class="student-review-date">
                        {{ $item->date_string }}
                    </div>
                </div>
            </div>
        @endforeach
        <review-item ng-repeat="item in review.items" item="item"></review-item>
    </div>

    @if ($data->currentPage() !== $data->lastPage())
        <center class='more-button' ng-if="review.hasMorePages">
            <button class="btn-border gray" ng-click="review.service.loadMore()">
                еще 10 из <b>{{ $data->total() }}</b> отзывов
            </button>
        </center>
    @endif
</div>
