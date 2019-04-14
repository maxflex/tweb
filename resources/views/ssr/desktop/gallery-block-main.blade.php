<div style='position: relative'>
    <div class="full-width-wrapper main-gallery-arrows">
        <div class="main-gallery-arrow left">
            <img src="/img/svg/left-arrow.svg" ng-click="GalleryService.prev()">
        </div>
        <div class="main-gallery-arrow right">
            <img src="/img/svg/right-arrow.svg" ng-click="GalleryService.next()">
        </div>
    </div>
    <div class="full-width-wrapper main-gallery-block" ng-init="initGallery('{{ $args->ids }}', '', '{{ $args->folders }}')">
        <div class="main-gallery-wrapper">
            <div class="gallery-item invisible">-</div>
            <div ng-repeat="g in GalleryService.gallery track by $index" class="gallery-item" ng-class="{'active': GalleryService.active == $index}">
                <gallery-item-main item='g' service='GalleryService'></gallery-item-main>
            </div>
            <div class="gallery-item invisible">-</div>
        </div>
    </div>
</div>
<div class='gallery-main hidden'>
    @foreach ($items as $item)
    <div class='gallery-main__item'>
        <img src='{{ $item->url }}'>
        <div>
            {{ $item->name }}
        </div>
    </div>
    @endforeach
</div>
