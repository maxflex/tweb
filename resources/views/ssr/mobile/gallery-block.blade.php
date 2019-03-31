<div class='header-1'>{{ $args->title }}</div>

@if (count($items) > 0)
<div class="vertical-slider" ng-init="initGallery('{{ $args->ids }}', '{{ $tags }}', '{{ $args->folders }}')" ng-show='galleryLoaded'>
    <div class="main-gallery-wrapper">
        <div ng-repeat="g in gallery" class="gallery-item">
           <gallery-item item='g' index='$index' service='GalleryService'></gallery-item>
        </div>
    </div>
</div>

<ng-image-gallery images="gallery" thumbnails='false' methods='GalleryService.ctrl' bg-close='true' img-anim="fadeup"></ng-image-gallery>

<div class="vertical-slider" ng-if='!galleryLoaded'>
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
<center style='color: #818181'>
    фотографий отсутстуют
</center>
@endif

<div class='block-separator block-separator_with-margins'></div>
