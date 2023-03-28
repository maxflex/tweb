<div class='header-1'> <h2 style="font-size: 28px; font-family: 'helveticaneuecyrregular';"> {{ $args->title }} </h2> </div>

@if ($data->total() > 0)
<div class="vertical-slider gallery-block-photos" ng-init="gallery.service.init({{ json_encode($args) }}, 'gallery', gallery.onLoaded)">
    <div class="main-gallery-wrapper">
        @foreach ($data->items() as $index => $item)
        <div class="gallery-item" ng-click="gallery.open({{ $index }})"
            @if($index === count($data->items()) - 1) in-view="firstLoadMoreInView(gallery)" @endif
        >
            <div>
                <img loading="lazy" src='{{ $item->thumb }}' alt="{{ $alt }} – photo{{$index + 1}}" class="gallery-photo" />
            </div>
            <div>
                <b>
                    {{ $item->name }} – {{ pluralize('день', 'дня', 'дней', $item->days_to_complete) }}
                </b>
            </div>
        </div>
        @endforeach
       <div ng-repeat="item in gallery.items track by $index" class="gallery-item" >
            <gallery-item item='item' ng-click='gallery.open($index + 3)'
                in-view="loadMoreInView(gallery, $index, $inview)"
                altt="{{ $alt }} – photo@{{$index + 4}}"
            ></gallery-item>
        </div>
    </div>
</div>

<ng-image-gallery images="images" thumbnails='false' methods='galleryMethods' bg-close='true' img-anim="fadeup"></ng-image-gallery>

@else
<div style='color: #818181; margin: 30px 0 55px'>
    фотографий отсутстуют
</div>
@endif

<div class='block-separator block-separator_with-margins'></div>
