@if (count($items) > 0)
    <div class="vertical-slider gallery-block-photos" ng-init="initGallery('{{ $args->ids }}', '', '{{ $args->folders }}')" ng-show='galleryLoaded'>
        <div class="main-gallery-wrapper">
            <div ng-repeat="g in gallery" class="gallery-item">
            <gallery-item item='g' index='$index' service='GalleryService'></gallery-item>
            </div>
        </div>
    </div>

    <ng-image-gallery images="gallery" thumbnails='false' methods='GalleryService.ctrl' bg-close='true' img-anim="fadeup"></ng-image-gallery>

    <div class="vertical-slider gallery-block-photos" ng-if='!galleryLoaded'>
        <div class="main-gallery-wrapper">
            @foreach ($items as $index => $item)
                <div class="gallery-item">
                    <div>
                        <img src='{{ $item->url }}'  class="gallery-photo">
                    </div>
                    <div>
                        <b>
                            {{ $item->name }}
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
