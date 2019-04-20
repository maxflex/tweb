<div class='header-1'>{{ $args->title }}</div>

@if (count($items) > 0)
<div class="vertical-slider gallery-block-photos" ng-init="initGallery('{{ $args->ids }}', '{{ $tags }}', '{{ $args->folders }}', false)" ng-show='galleryLoaded'>
    <div class="main-gallery-wrapper">
        <div ng-repeat="g in gallery2" class="gallery-item">
           <gallery-item item='g' index='$index' service='GalleryService2'></gallery-item>
        </div>
    </div>
</div>

<ng-image-gallery-2 images="gallery2" thumbnails='false' methods='GalleryService2.ctrl' bg-close='true' img-anim="fadeup"></ng-image-gallery-2>

<div class="vertical-slider gallery-block-photos" ng-if='!galleryLoaded'>
    <div class="main-gallery-wrapper">
        @foreach ($items as $index => $item)
            <div class="gallery-item">
                <div>
                    <img src='{{ $item->url }}'  class="gallery-photo">
                </div>
                <div>
                    <b>
                        {{ $item->name }} – {{ $item->day_to_complete }} дней
                    </b>
                </div>
            </div>
        @endforeach
    </div>
</div>

@else
<div style='color: #818181; margin: 30px 0 55px'>
    фотографий отсутстуют
</div>
@endif

<div class='block-separator block-separator_with-margins'></div>
