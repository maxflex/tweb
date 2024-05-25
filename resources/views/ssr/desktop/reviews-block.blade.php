<div ng-if='true'>

    @php
        $a = [4.6, 4.7, 4.8, 4.9, 5.0];
    @endphp

    @if(count($data->items()) > 0)
        <center style="padding-top: 25px;"><h2>Отзывы об ателье Талисман</h2></center>
    @endif

    <div class="reviews-wrapper" itemprop="aggregateRating" itemtype="//schema.org/AggregateRating" itemscope ng-init="review.service.init({{ json_encode($args) }}, 'review', review.onLoaded)">
        @foreach ($data->items() as $item)
            <div class="student-review">
                <meta itemprop="bestRating" content="5" />
                <meta itemprop="worstRating" content="1" />
                <meta itemprop="ratingValue" content="{{ $a[rand(0, 4)] }}" />
                <meta itemprop="ratingCount" content="1" />
                <meta itemprop="author" content="{{ $item->signature }}" />
                <div itemprop="itemReviewed" itemscope itemtype="https://schema.org/Organization">
                    <meta itemprop="name" content="Ателье Талисман"/>
                    <meta itemprop="address" content="г.Москва"/>
                    <meta itemprop="telephone" content="+7 495 215-22-31" />
                </div>
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

    <meta itemprop="ratingValue" content="{{ $a[rand(0, 4)] }}" />
    <meta itemprop="reviewCount" content="{{ $data->total() }}" />

</div>
