angular
    .module 'App'
    .controller 'Index', ($scope, $timeout, $http, PriceSection) ->
        bindArguments($scope, arguments)

        $scope.player = {}

        $timeout ->
            $scope.prices = PriceSection.query()

            $scope.displayed_videos = 3
            $scope.videos.forEach (v) -> bindFullscreenRequest(v)
            # $scope.has_more_videos = true
            # $scope.videos_page = 0
            # $scope.videos = []
            # searchVideos()

            $scope.has_more_reviews = true
            $scope.reviews_page = 0
            $scope.reviews = []
            searchReviews()

            $scope.gallery_obj = {} #
            $scope.has_more_gallery = true
            $scope.gallery_page = 0
            $scope.gallery = []
            searchGallery()

            initGmap()

        # REVIEWS
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

        # VIDEOS
        $scope.nextVideosPage = ->
            $scope.videos_page++
            # StreamService.run('load_more_tutors', null, {page: $scope.page})
            searchVideos()

        searchVideos = ->
            $scope.searching_videos = true
            $http.get('/api/videos?page=' + $scope.videos_page).then (response) ->
                $scope.searching_videos = false
                $scope.videos = $scope.videos.concat(response.data.videos)
                $scope.has_more_videos = response.data.has_more_videos
                $timeout -> response.data.videos.forEach (v) -> bindFullscreenRequest(v)
                # if $scope.mobile then $timeout -> bindToggle()

        # длительность видео
        $scope.videoDuration = (v) ->
            if v.duration
                format = if v.duration >= 60 then 'm:ss' else 'ss'
                moment.utc(v.duration * 1000).format(format)

        bindFullscreenRequest = (video) ->
            console.log("binding for video #{video.id}")
            iframe = document.getElementById("youtube-video-#{video.id}")
            requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen
            player = new YT.Player "youtube-video-#{video.id}",
                events:
                    onReady: (p) ->
                        video.duration = p.target.getDuration()
                        $timeout -> $scope.$apply()
            $scope.player[video.id] = player
            $scope.player[video.id].addEventListener 'onStateChange', (state) ->
                requestFullScreen.bind(iframe)()

        # GALLERY

        $scope.showMoreGallery = ->
            $scope.gallery_obj.page = if not $scope.gallery_obj.page then 1 else ($scope.gallery_obj.page + 1)
            from = ($scope.gallery_obj.page - 1) * 6
            to = from + 6
            $scope.gallery_obj.displayed = $scope.gallery.slice(0, to)

        $scope.nextGalleryPage = ->
            $scope.gallery_page++
            # StreamService.run('load_more_tutors', null, {page: $scope.page})
            searchGallery()


        $scope.openPhoto = (index) ->
            # StreamService.run('photogallery', "open_#{photo_id}")
            $scope.galleryCtrl.open(index)

        searchGallery = ->
            $scope.searching_gallery = true
            $http.get('/api/gallery?page=' + $scope.gallery_page).then (response) ->
                $scope.searching_gallery = false
                $scope.gallery = $scope.gallery.concat(response.data.gallery)
                # response.data.gallery.forEach (photo) ->
                #     new_photo = _.clone(photo)
                #     new_photo.id = Math.round(Math.random(1, 999999) * 100000)
                #     $scope.gallery.push(new_photo)
                $scope.has_more_gallery = response.data.has_more_gallery
                $scope.showMoreGallery()
                # if $scope.mobile then $timeout -> bindToggle()

        $scope.playVideo = ->
            $scope.player.loadVideoById('qQS-d4cJr0s')
            $scope.player.playVideo()
            iframe = document.getElementById('youtube-video')
            requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
            requestFullScreen.bind(iframe)() if (requestFullScreen)

        $scope.openPhotoSwipe = (index) ->
            $scope.items = []
            $scope.gallery.forEach (g) ->
                $scope.items.push
                    src: g.url
                    msrc: g.url
                    w: 2200
                    h: 1100
                    title: g.name
                    master: g.master
                    components: g.components
                    total_price: g.total_price
                    days_to_complete: g.days_to_complete

            pswpElement = document.querySelectorAll('.pswp')[0]

            options =
                getThumbBoundsFn: (index) ->
                    thumbnail = document.getElementById("p-#{index}")
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop
                    rect = thumbnail.getBoundingClientRect()
                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width}
                history: false
                focus: false
                index: parseInt(index)
                tapToToggleControls: false
                captionEl: false
                arrowEl: true
                animateTransitions: true
                closeOnVerticalDrag: false
                closeOnScroll: false
                # modal:false

            $scope.PhotoSwipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, $scope.items, options)
            $scope.PhotoSwipe.init()
            $scope.PhotoSwipe.listen 'preventDragEvent', (e, isDown, preventObj) -> preventObj.prevent = true
            # $scope.PhotoSwipe.listen 'preventDragEvent', (e, isDown, preventObj) ->
            #     e = $(e.target)
            #     # console.log(e)
            #     if e.hasClass('.pswp__button')
            #         preventObj.prevent = true
            #     else
            #         preventObj.prevent = false

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
                newMarker(new google.maps.LatLng(55.7173112, 37.5929021), $scope.map),
                newMarker(new google.maps.LatLng(55.781081,  37.5141053), $scope.map),
            ]

            markers.forEach (marker) ->
                marker_location = new google.maps.LatLng(marker.lat, marker.lng)
                # closest_metro = marker.metros[0]
                $scope.bounds.extend(marker_location)

            $scope.map.fitBounds $scope.bounds
            $scope.map.panToBounds $scope.bounds

            if isMobile

            else
                $scope.map.panBy(-200, 0)

            if (isMobile)
                window.onOpenModal = ->
                    google.maps.event.trigger($scope.map, 'resize')
                    $scope.map.fitBounds $scope.bounds
                    $scope.map.panToBounds $scope.bounds
