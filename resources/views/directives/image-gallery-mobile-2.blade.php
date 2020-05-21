<div class="ng-image-gallery img-move-dir-@{{_imgMoveDirection}}" ng-class="{inline:inline}" ng-hide="images.length == 0">
        <div ng-if="thumbnails && !inline" class="ng-image-gallery-thumbnails">
            <div class="thumb" ng-repeat="image in images track by image.url" ng-click="methods.open($index);" show-image-async="@{{image.thumbUrl || image.url}}" async-kind="thumb" ng-style="{'width' : thumbSize+'px', 'height' : thumbSize+'px'}">
                <div class="loader"></div>
            </div>
        </div>

        <div class="ng-image-gallery-modal" ng-if="opened" ng-cloak>

            <div class="ng-image-gallery-backdrop" ng-if="!inline"></div>

            <div class="ng-image-gallery-content">

                <div class="galleria">

                    <div class="gallery-photo-master-info gallery-mobile" style='position: relative' ng-repeat="image in images track by image.id" ng-if="_activeImg == image">
                        <div style="display: flex; height: 40px; align-items: center">
                            <b style='flex: 1'>@{{ image.name }}</b>
                            <div class="gallery-flow-control gallery-close" style="position: initial">
                                <div ng-click="methods.close()" class="gallery-flow-control-arrow" style="margin: 0 !important">
                                    <img src="/img/svg/cross.svg" />
                                </div>
                            </div>
                        </div>
                        <div class="galleria-images img-anim-@{{imgAnim}} img-move-dir-@{{_imgMoveDirection}}">
                            <img class="galleria-image" ng-right-click  ng-src="@{{image.url}}" ondragstart="return false;" ng-attr-alt="@{{image.alt || undefined}}"/>
                            <div class="gallery-flow-control gallery-left-right">
                                <div ng-click="methods.prev()" ng-hide="images.length == 1" class="gallery-flow-control-arrow">
                                    <img src="/img/svg/left-arrow.svg" />
                                </div>
                                <span ng-bind-html="(_activeImageIndex + 1) + ' / ' + (images.length) | ngImageGalleryTrust"></span>
                                <div ng-click="methods.next()" ng-hide="images.length == 1" class="gallery-flow-control-arrow">
                                    <img src="/img/svg/right-arrow.svg" />
                                </div>
                            </div>
                        </div>


                        <div class="galleria-bubbles-wrapper" ng-if="bubbles && !imgBubbles" ng-hide="images.length == 1" bubble-auto-fit>
                            <div class="galleria-bubbles" bubble-auto-scroll ng-style="{'margin-left': _bubblesContainerMarginLeft + 'px'}">
                                <span class="galleria-bubble img-bubble" ng-click="_setActiveImg(image);" ng-repeat="image in images track by image.id" ng-class="{active : (_activeImg == image)}" show-image-async="@{{image.bubbleUrl || image.thumbUrl || image.url}}" async-kind="bubble"></span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="ng-image-gallery-errorplaceholder" ng-show="imgError">
                <div class="ng-image-gallery-error-placeholder" ng-bind-html="errorPlaceHolder | ngImageGalleryTrust"></div>
            </div>
        </div>
    </div>
