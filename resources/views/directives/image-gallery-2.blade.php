<div class="ng-image-gallery img-move-dir-@{{_imgMoveDirection}}" ng-class="{inline:inline}" ng-hide="images.length == 0">
        <div ng-if="thumbnails && !inline" class="ng-image-gallery-thumbnails">
            <div class="thumb" ng-repeat="image in images track by image.url" ng-click="methods.open($index);" show-image-async="@{{image.thumbUrl || image.url}}" async-kind="thumb" ng-style="{'width' : thumbSize+'px', 'height' : thumbSize+'px'}">
                <div class="loader"></div>
            </div>
        </div>

        <div class="ng-image-gallery-modal" ng-if="opened" ng-cloak>

            <div class="ng-image-gallery-backdrop" ng-if="!inline"></div>

            <div class="ng-image-gallery-content">
                {{-- <div class="control-icons-container">
                    <a class="ext-url" ng-repeat="image in images track by image.id" ng-if="_activeImg == image && image.extUrl" href="@{{image.extUrl}}" target="_blank" title="Open image in new tab..."></a>
                    <div class="close" ng-click="methods.close();" ng-if="!inline"></div>
                </div>
                <div class="prev-wrapper" ng-click="methods.prev();">
                    <div class="prev" ng-class="{'bubbles-on':bubbles}" ng-hide="images.length == 1"></div>
                </div>
                <div class="next-wrapper" ng-click="methods.next();">
                    <div class="next" ng-class="{'bubbles-on':bubbles}" ng-hide="images.length == 1"></div>
                </div>
                <div ng-repeat="image in images track by image.id" ng-if="_activeImg == image">
                    <div class="title" ng-bind-html="'Фото ' + ($index + 1) + ' из ' + (images.length) | ngImageGalleryTrust"></div>
                    <div class="desc" ng-if="image.desc" ng-bind-html="image.desc | ngImageGalleryTrust"></div>
                </div> --}}

                <div class="galleria">

                    <div class="gallery-photo-master-info" style='position: relative'>
                        <div ng-show="!imgLoading" class="galleria-images img-anim-@{{imgAnim}} img-move-dir-@{{_imgMoveDirection}}">
                            <img style='margin: 0 auto; max-width: 80%' class="galleria-image" ng-show="!imgLoading" ng-right-click ng-repeat="image in images track by image.id" ng-if="_activeImg == image" ng-src="@{{image.url}}" ondragstart="return false;" ng-attr-alt="@{{image.alt || undefined}}"/>
                            <b class="image-gallery-2-title" ng-repeat="image in images track by image.id"  ng-if="_activeImg == image">@{{ image.name }}</b>
                        </div>
                        <div class="gallery-flow-control gallery-close">
                            <div ng-click="methods.close()" class="gallery-flow-control-arrow">
                                <img src="/img/svg/cross.svg" />
                            </div>
                        </div>
                    </div>

                    <div class="gallery-bottom-controls">
                        <div class="gallery-flow-control">
                            <div ng-click="methods.prev()" ng-hide="images.length == 1" class="gallery-flow-control-arrow">
                                <img src="/img/svg/left-arrow.svg" />
                            </div>
                            <span ng-bind-html="(_activeImageIndex + 1) + ' / ' + (images.length) | ngImageGalleryTrust"></span>
                            <div ng-click="methods.next()" ng-hide="images.length == 1" class="gallery-flow-control-arrow">
                                <img src="/img/svg/right-arrow.svg" />
                            </div>
                        </div>

                        <div class="galleria-bubbles-wrapper" ng-if="bubbles && !imgBubbles" ng-hide="images.length == 1" bubble-auto-fit>
                            <div class="galleria-bubbles" bubble-auto-scroll ng-style="{'margin-left': _bubblesContainerMarginLeft + 'px'}">
                                <span class="galleria-bubble img-bubble" ng-click="_setActiveImg(image);" ng-repeat="image in images track by image.id" ng-class="{active : (_activeImg == image)}" show-image-async="@{{image.bubbleUrl || image.thumbUrl || image.url}}" async-kind="bubble"></span>
                            </div>
                        </div>

                        {{-- <div class="galleria-bubbles-wrapper" ng-if="bubbles && imgBubbles" ng-hide="images.length == 1" ng-style="{'height' : bubbleSize+'px'}" bubble-auto-fit>
                            <div class="galleria-bubbles" bubble-auto-scroll ng-style="{'margin-left': _bubblesContainerMarginLeft}">
                                <span class="galleria-bubble img-bubble" ng-click="_setActiveImg(image);" ng-repeat="image in images track by image.id" ng-class="{active : (_activeImg == image)}" show-image-async="@{{image.bubbleUrl || image.thumbUrl || image.url}}" async-kind="bubble" ng-style="{'width' : bubbleSize+'px', 'height' : bubbleSize+'px', 'border-width' : bubbleSize/10+'px', margin: _bubbleMargin}"></span>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>

            <div class="ng-image-gallery-loader" ng-show="imgLoading">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>

            <div class="ng-image-gallery-errorplaceholder" ng-show="imgError">
                <div class="ng-image-gallery-error-placeholder" ng-bind-html="errorPlaceHolder | ngImageGalleryTrust"></div>
            </div>
        </div>
    </div>
