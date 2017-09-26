angular
    .module 'App'
    .controller 'Index', ($scope, $timeout, $http) ->
        bindArguments($scope, arguments)

        $timeout ->
            $scope.has_more_reviews = true
            $scope.reviews_page = 0
            $scope.reviews = []
            searchReviews()

            $scope.has_more_gallery = true
            $scope.gallery_page = 0
            $scope.gallery = []
            searchGallery()

            initGmap()

            iframe = document.getElementById('youtube-video')
            requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen
            $scope.player = new YT.Player 'youtube-video', {}
            $scope.player.addEventListener 'onStateChange', (state) -> requestFullScreen.bind(iframe)()

        $scope.nextReviewsPage = ->
            $scope.reviews_page++
            # StreamService.run('load_more_tutors', null, {page: $scope.page})
            searchReviews()

        searchReviews = ->
            $scope.searching_reviews = true
            $http.get('/api/reviews?page=' + $scope.reviews_page).then (response) ->
                $scope.searching_reviews = false
                $scope.reviews = $scope.reviews.concat(response.data.reviews)
                $scope.has_more_reviews = response.data.has_more_reviews
                # if $scope.mobile then $timeout -> bindToggle()

        # GALLERY
        $scope.nextGalleryPage = ->
            $scope.gallery_page++
            # StreamService.run('load_more_tutors', null, {page: $scope.page})
            searchGallery()

        searchGallery = ->
            $scope.searching_gallery = true
            $http.get('/api/gallery?page=' + $scope.gallery_page).then (response) ->
                $scope.searching_gallery = false
                $scope.gallery = $scope.gallery.concat(response.data.gallery)
                $scope.has_more_gallery = response.data.has_more_gallery
                # if $scope.mobile then $timeout -> bindToggle()

        $scope.playVideo = ->
            $scope.player.loadVideoById('qQS-d4cJr0s')
            $scope.player.playVideo()
            iframe = document.getElementById('youtube-video')
            requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
            requestFullScreen.bind(iframe)() if (requestFullScreen)

        initGmap = ->
            $scope.map = new google.maps.Map(document.getElementById("map"), {
                scrollwheel: false,
                disableDefaultUI: true,
                clickableLabels: false,
                clickableIcons: false,
                zoomControl: true,
                zoomControlOptions: {position: google.maps.ControlPosition.LEFT_BOTTOM},
                scaleControl: true
            })
            marker = newMarker(new google.maps.LatLng(55.7173112, 37.5929021), $scope.map)
            $scope.map.setCenter(marker.getPosition())
            $scope.map.setZoom(14)
            if (isMobile)
                window.onOpenModal = ->
                    google.maps.event.trigger($scope.map, 'resize')
                    $scope.map.setCenter(marker.getPosition())
                    $scope.map.setZoom(14)
