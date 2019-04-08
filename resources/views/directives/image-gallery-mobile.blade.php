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

                    <div class="gallery-photo-master-info" style='position: relative' ng-repeat="image in images track by image.id" ng-if="_activeImg == image">
                        <div>
                            <b style='position: relative; top: 6px'>@{{ image.name }}</b>
                            <div class="gallery-flow-control gallery-close">
                                <div ng-click="methods.close()" ng-hide="images.length == 1" class="gallery-flow-control-arrow">
                                    <img src="/img/svg/cross.svg" />
                                </div>
                            </div>
                        </div>
                        <div ng-show="!imgLoading" class="galleria-images img-anim-@{{imgAnim}} img-move-dir-@{{_imgMoveDirection}}">
                            <img ng-click="methods.next()" class="galleria-image" ng-show="!imgLoading" ng-right-click  ng-src="@{{image.url}}" ondragstart="return false;" ng-attr-alt="@{{image.alt || undefined}}"/>
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
                        </div>

                        <div class="gallery-components">
                            <div ng-show="image.component_1">
                                <span>@{{ image.component_1 }}</span> –
                                <span>@{{ image.price_1 | number }} руб.</span>
                            </div>
                            <div ng-show="image.component_2">
                                <span>@{{ image.component_2 }}</span> –
                                <span>@{{ image.price_2 | number }} руб.</span>
                            </div>
                            <div ng-show="image.component_3">
                                <span>@{{ image.component_3 }}</span> –
                                <span>@{{ image.price_3 | number }} руб.</span>
                            </div>
                            <div ng-show="image.component_4">
                                <span>@{{ image.component_4 }}</span> –
                                <span>@{{ image.price_4 | number }} руб.</span>
                            </div>
                            <div ng-show="image.component_5">
                                <span>@{{ image.component_5 }}</span> –
                                <span>@{{ image.price_5 | number }} руб.</span>
                            </div>
                            <div ng-show="image.component_6">
                                <span>@{{ image.component_6 }}</span> –
                                <span>@{{ image.price_6 | number }} руб.</span>
                            </div>
                            <div class="gallery-component-sum" ng-if="image.total_price">
                                <span>Итого:</span>
                                <span>@{{ image.total_price | number }} руб.</span>
                            </div>
                            <div ng-if="image.days_to_complete">
                                <span>Срок выполнения:</span>
                                <span class="gallery-days-to-complete"><plural count="image.days_to_complete" type='day'></plural></span>
                            </div>
                        </div>

                        <div class="master-photo" ng-if="image.master">
                            <div>
                                <img ng-src="@{{image.master.photo_url}}" />
                            </div>
                            <div style='flex-direction: column'>
                                <div class="master-name">
                                    Мастер-исполнитель
                                </div>
                                <div>
                                    @{{ image.master.last_name }} @{{ image.master.first_name }} @{{ image.master.middle_name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="ng-image-gallery-loader" ng-show="imgLoading">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    {{-- <div class="rect5"></div> --}}
                </div>
            </div>

            <div class="ng-image-gallery-errorplaceholder" ng-show="imgError">
                <div class="ng-image-gallery-error-placeholder" ng-bind-html="errorPlaceHolder | ngImageGalleryTrust"></div>
            </div>
        </div>
    </div>
