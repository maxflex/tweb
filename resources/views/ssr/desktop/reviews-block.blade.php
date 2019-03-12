<div ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    <div class="reviews-wrapper">
        @foreach ($items as $index => $item)
            <div class="student-review @if (($index + 1) === count($items)) student-review-last @endif" ng-hide='options.show <= {{ $index }}'>
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
    </div>

    @if (count($items))
        <center class='more-button' ng-show='options.show < {{ count($items) }}'>
            <button class="btn-border gray" ng-click="console.log('allo'); options.show = options.show + options.showBy">
                еще {{ $options['showBy'] }} из <b>{{ count($items) }}</b> отзывов
            </button>
        </center>
    @endif
</div>
