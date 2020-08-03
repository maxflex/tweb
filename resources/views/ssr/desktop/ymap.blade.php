<div class="ymap-container show-on-print" style="width: 100%; @if(!isMobile()) height: 480px @endif" ng-init="panorama = false">
    @if($panoramaLink)
    <div class="plag-map--button" ng-click="panorama = !panorama">
        <span ng-if="panorama">
            <i class="fas fa-map-marker-alt"></i>
            Карта
        </span>
        <span ng-if="!panorama">
            <i class="fas fa-male"></i>
            Панорама
        </span>
    </div>
    <iframe ng-show="panorama" src="{{ $panoramaLink }}" frameborder="0" style="width: 100%; height: 100%" allowfullscreen="true"></iframe>
    @endif
    <div class="ymap" id="map" ng-show="!panorama"></div>
</div>
<script type="text/javascript">
    // Функция ymaps.ready() будет вызвана, когда
    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);
    function init(){
        var sizeDown = 0.25
        // Создание карты.
        var myMap = new ymaps.Map("map", {
            center: [{{ $latLng[$map] }}],
            // Уровень масштабирования. Допустимые значения:
            // от 0 (весь мир) до 19.
            zoom: {{ $zoom }},
            controls: ['zoomControl', 'rulerControl', 'geolocationControl'],
        });

        @if($route->latLng)
            // myMap.geoObjects.add(new ymaps.Placemark([{{ $route->latLng }}], {}, { preset: 'islands#redIcon' }));
            var multiRoute = new ymaps.multiRouter.MultiRoute({
                referencePoints: [
                    [{{ $route->latLng }}],
                    [{{ $latLng[$map] }}]
                ],
                params: {
                    routingMode: "{{ $route->mode }}"
                }
            }, {
                 wayPointFinishVisible:false,
                // Внешний вид линии активного маршрута.
                routeActiveStrokeWidth: 3,
                routeActiveStrokeColor: "#ae4037",
                routeStrokeStyle: "solid",
                routeStrokeColor: "#ffffff00",
                boundsAutoApply: true
            });
            myMap.geoObjects.add(multiRoute);
        @endif

            @foreach($maps as $m)
                myMap.geoObjects.add(new ymaps.Placemark([{{ $latLng[$m] }}], {
                    balloonContent: `{!! view("balloon.{$m}") !!}`,
                    balloonPanelMaxMapArea: 0,
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '/img/maps/marker.png',
                    iconImageSize: [191 * sizeDown, 222 * sizeDown],
                }));
            @endforeach
    }
</script>
