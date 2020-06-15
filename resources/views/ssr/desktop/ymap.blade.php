<div id="map" style="width: 100%; height: 480px"></div>

<script type="text/javascript">
    // Функция ymaps.ready() будет вызвана, когда
    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);
    function init(){
        // Создание карты.
        var myMap = new ymaps.Map("map", {
            center: [55.781302, 37.516040],
            // Уровень масштабирования. Допустимые значения:
            // от 0 (весь мир) до 19.
            zoom: 14,
            controls: ['zoomControl', 'rulerControl', 'trafficControl', 'geolocationControl'],
        });
        var myPlacemark = new ymaps.Placemark([55.781302, 37.516040], {
            balloonContent: `{!! $balloonContent !!}`,
        });
        myMap.geoObjects.add(myPlacemark);
    }
</script>
