<div class="ymap show-on-print" id="map" style="width: 100%; height: 480px"></div>
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
            controls: ['zoomControl', 'rulerControl', 'trafficControl', 'geolocationControl'],
        });
            @foreach($maps as $m)
                myMap.geoObjects.add(new ymaps.Placemark([{{ $latLng[$m] }}], {
                    balloonContent: `{!! view("balloon.{$m}") !!}`,
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: '/img/maps/marker.png',
                    iconImageSize: [191 * sizeDown, 222 * sizeDown],
                }));
            @endforeach
    }
</script>
