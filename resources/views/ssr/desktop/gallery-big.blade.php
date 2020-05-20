<div style='position: relative; min-height: 582px' >
    <div class="full-width-wrapper main-gallery-arrows">
        <div class="main-gallery-arrow left" ng-click="GalleryService.prev()">
            <img src="/img/svg/left-arrow.svg">
        </div>
        <div class="main-gallery-arrow right" ng-click="GalleryService.next()">
            <img src="/img/svg/right-arrow.svg">
        </div>
    </div>
    <div class="full-width-wrapper main-gallery-block" ng-class="{'invisible': !galleryLoaded}" ng-init="initGallery('{{ $args->ids }}', '{{ $tags }}', '{{ $args->folders }}', true, true)">
        <div class="main-gallery-wrapper">
            <div class="gallery-item invisible">-</div>
            <div ng-repeat="g in GalleryService.gallery track by $index" class="gallery-item" ng-class="{'active pointer': GalleryService.active == $index}">
                <gallery-item-main
                    ng-click="$index === GalleryService.active ? GalleryService.open($index - 1) : null"
                    item='g'
                ></gallery-item-main>
            </div>
            <div class="gallery-item invisible">-</div>
        </div>
    </div>
    {{-- <div class="full-width-wrapper main-gallery-block" ng-if="!galleryLoadedDelay">
        <div class="main-gallery-wrapper" style="margin-left: calc((1000px - ((100vw - 1000px) / 2)) * -1)">
            @foreach ($items as $index => $item)
            <div class="gallery-item @if($index === 1) active @endif">
                <div>
                    <img class="gallery-photo pointer" src='{{ $item->thumb }}'>
                </div>
                <div class="gallery-header">
                    {{ $item->name }}
                </div>
            </div>
            @endforeach
        </div>
    </div> --}}
</div>
<ng-image-gallery-2 images="gallery" thumbnails='false' methods='GalleryService.ctrl' bg-close='true'></ng-image-gallery-2>
