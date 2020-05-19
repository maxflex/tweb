<div style='position: relative; min-height: 582px' >
    <div class="full-width-wrapper main-gallery-arrows">
        <div class="main-gallery-arrow left">
            <img src="/img/svg/left-arrow.svg" ng-click="GalleryService.prev()">
        </div>
        <div class="main-gallery-arrow right">
            <img src="/img/svg/right-arrow.svg" ng-click="GalleryService.next()">
        </div>
    </div>
    <div class="full-width-wrapper main-gallery-block" ng-class="{'invisible': !galleryLoaded}" ng-init="initGallery('{{ $args->ids }}', '{{ $tags }}', '{{ $args->folders }}', true, true)">
        <div class="main-gallery-wrapper">
            <div class="gallery-item invisible">-</div>
            <div ng-repeat="g in gallery track by $index" class="gallery-item" ng-class="{'active': GalleryService.active == $index}">
                <gallery-item-main
                    ng-click="$index === GalleryService.active ? GalleryService.open($index) : null"
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
<ng-image-gallery images="gallery" thumbnails='false' methods='GalleryService.ctrl' bg-close='true'></ng-image-gallery>
