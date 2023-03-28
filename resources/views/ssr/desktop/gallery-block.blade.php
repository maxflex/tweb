@if($args->title)
<div class='header-1'><h2 style="font-size: 28px; font-family: 'helveticaneuecyrregular';"> {{ $args->title }} </h2></div>
@endif

@if ($data->total() > 0)
<div class='relative gallery-block-placeholder' ng-init="gallery.service.init({{ json_encode($args) }}, 'gallery', gallery.onLoaded)">
    <div class="gallery-block gallery-block-photos">
        <div class="main-gallery-wrapper">
            @foreach ($data->items() as $index => $item)
            <div class='gallery-item'>
                <div>
                    <img loading="lazy" ng-click="gallery.open({{ $index }})" src='{{ $item->thumb }}' class="gallery-photo pointer" alt="{{ $alt }} – photo{{$index + 1}}" />
                </div>
                <div>
                    <div class="entity-header header-3 gallery-preview-header">
                        {{ $item->name }}
                        <span class="address-gallery-remove">
                            –
                            {{ pluralize('день', 'дня', 'дней', $item->days_to_complete) }}
                            <a class="link-small pointer" ng-click="gallery.open({{ $index }})">подробнее...</a>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
            <div ng-repeat="item in gallery.items track by $index" class="gallery-item">
                <gallery-item item='item' ng-click='gallery.open($index + 3)' altt="{{ $alt }} – photo@{{$index + 4}}"></gallery-item>
            </div>
        </div>
        @if ($data->currentPage() !== $data->lastPage())
        <center ng-if="gallery.hasMorePages" class='more-button' style='margin: 35px 0 0'>
            <button class="btn-border"ng-click="gallery.service.loadMore()">показать ещё</button>
        </center>
        @endif
    </div>
</div>
<ng-image-gallery images="images" thumbnails='false' methods='galleryMethods' bg-close='true'></ng-image-gallery>

<div class="gallery-loading-backdrop ng-hide" ng-show="galleryLoadingStatus === 'loading'">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>

@else
<center style='color: #818181'>
    фотографии отсутстуют
</center>
@endif
