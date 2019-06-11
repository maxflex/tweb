<div class='header-1'>{{ $args->title }}</div>

@if (count($items) > 0)
<div class='relative gallery-block-placeholder'>
    <div class="gallery-block gallery-block-photos" ng-init="initGallery('{{ $args->ids }}', '{{ $tags }}', '{{ $args->folders }}')" ng-show='galleryLoaded'>
        <div class="main-gallery-wrapper">
            <div ng-repeat="g in gallery.slice(0, GalleryService.displayed) track by $index" class="gallery-item">
                <gallery-item item='g' index='$index' service='GalleryService'></gallery-item>
            </div>
        </div>
        <center ng-show='GalleryService.displayed < gallery.length' class='more-button' style='margin: 35px 0 0'>
            <button class="btn-border" ng-click='GalleryService.displayed = GalleryService.displayed + 3'>показать ещё</button>
        </center>
    </div>
    <ng-image-gallery images="gallery" thumbnails='false' methods='GalleryService.ctrl' bg-close='true'></ng-image-gallery>

    <div class='gallery-block gallery-block-photos' ng-if="!galleryLoaded">
        <div class="main-gallery-wrapper">
            @foreach ($items as $index => $item)
                <div class='gallery-item' @if ($index >= 3) style='display: none' @endif >
                    <div>
                        <img src='{{ $item->thumb }}' class="gallery-photo pointer">
                    </div>
                    <div>
                        <div class="entity-header header-3">
                            {{ $item->name }} – {{ $item->days_to_complete }} дней
                            <a class="link-small pointer" href='#'>подробнее...</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if (count($items) > 3)
            <center class='more-button' style='margin: 35px 0 0'>
                <button class="btn-border">показать ещё</button>
            </center>
        @endif
    </div>
</div>
@else
<center style='color: #818181'>
    фотографий отсутстуют
</center>
@endif
