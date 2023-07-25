<div class="info-section" style='margin-bottom: 44px' ng-init="review.service.init({{ json_encode($args) }}, 'review', review.onLoaded)">

    @php
        $a = [4.6, 4.7, 4.8, 4.9, 5.0];
    @endphp

    @if(count($data->items()) > 0)
        <center style="margin: 10px 0 30px"><h2>Отзывы об ателье Талисман</h2></center>
    @endif

     @foreach ($data->items() as $item)
        <div class="student-review">
            <div class="student-review-header">
                <div class="student-review-photo"></div>
                <div class="student-review-info">
                    <meta itemprop="bestRating" content="5" />
                    <meta itemprop="worstRating" content="1" />
                    <meta itemprop="author" content="{{ $item->signature }}" />
                    <div class="student-review-name">{{ $item->signature }}</div>
                    <div class="student-review-date">
                        {{ $item->date_string }}
                    </div>
                </div>
            </div>
            <div class="student-review-text">
                <div class="student-review-comment">
                    <span>{{ $item->body }}</span>
                    @if ($item->master)
                        <span>
                            Мастер:
                                <a href='/masters/{{ $item->master->id }}/'>{{ $item->master->first_name }} {{ $item->master->middle_name }}</a>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    <review-item ng-repeat="item in review.items" item="item"></review-item>
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
