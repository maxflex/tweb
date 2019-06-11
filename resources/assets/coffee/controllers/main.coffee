angular
    .module 'App'
    .controller 'main', ($scope, $timeout, $http, GalleryService) ->
        bindArguments($scope, arguments)

        $scope.galleryLoaded = false
        $scope.GalleryService2 = _.clone(GalleryService)

        $scope.initGallery = (ids, tags, folders, isFirst = true) ->
            $http.post '/api/gallery/init', {ids: ids, tags: tags, folders: folders}
            .then (response) ->
                # $timeout ->
                $scope.gallery = response.data if isFirst
                $scope.gallery2 = response.data if not isFirst
                $scope.galleryLoaded = true
                # , 3000

        $timeout ->
            PriceExpander.expand(if isMobile then 15 else 30) 
            initGmap()

        # $scope.openPhotoSwipe = (index) ->
        #     $scope.items = []
        #     $scope.gallery.forEach (g) ->
        #         $scope.items.push
        #             src: g.url
        #             msrc: g.url
        #             w: 2200
        #             h: 1100
        #             title: g.name
        #             master: g.master
        #             components: g.components
        #             total_price: g.total_price
        #             days_to_complete: g.days_to_complete

        #     pswpElement = document.querySelectorAll('.pswp')[0]

        #     options =
        #         getThumbBoundsFn: (index) ->
        #             thumbnail = document.getElementById("p-#{index}")
        #             pageYScroll = window.pageYOffset || document.documentElement.scrollTop
        #             rect = thumbnail.getBoundingClientRect()
        #             return {x:rect.left, y:rect.top + pageYScroll, w:rect.width}
        #         history: false
        #         focus: false
        #         index: parseInt(index)
        #         tapToToggleControls: false
        #         captionEl: false
        #         arrowEl: true
        #         animateTransitions: true
        #         closeOnVerticalDrag: false
        #         closeOnScroll: false
        #         # modal:false

        #     $scope.PhotoSwipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, $scope.items, options)
        #     $scope.PhotoSwipe.init()
        #     $scope.PhotoSwipe.listen 'preventDragEvent', (e, isDown, preventObj) -> preventObj.prevent = true
        #     # $scope.PhotoSwipe.listen 'preventDragEvent', (e, isDown, preventObj) ->
        #     #     e = $(e.target)
        #     #     # console.log(e)
        #     #     if e.hasClass('.pswp__button')
        #     #         preventObj.prevent = true
        #     #     else
        #     #         preventObj.prevent = false

        initGmap = ->
            $scope.map = new google.maps.Map(document.getElementById("map"), {
                scrollwheel: false,
                disableDefaultUI: true,
                clickableLabels: false,
                clickableIcons: false,
                zoomControl: true,
                zoomControlOptions: {position: google.maps.ControlPosition.RIGHT_CENTER},
                scaleControl: false
            })

            $scope.bounds = new (google.maps.LatLngBounds)

            markers = [
                newMarker(new google.maps.LatLng(55.717295, 37.595088), $scope.map),
                newMarker(new google.maps.LatLng(55.781302,  37.516045), $scope.map),
            ]

            markers.forEach (marker) ->
                marker_location = new google.maps.LatLng(marker.lat, marker.lng)
                # closest_metro = marker.metros[0]
                $scope.bounds.extend(marker_location)

            $scope.map.fitBounds $scope.bounds
            $scope.map.panToBounds $scope.bounds

            # if isMobile
            #
            # else
            #     $scope.map.panBy(-200, 0)

            if (isMobile)
                window.onOpenModal = ->
                    google.maps.event.trigger($scope.map, 'resize')
                    $scope.map.fitBounds $scope.bounds
                    $scope.map.panToBounds $scope.bounds
