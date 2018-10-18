angular
    .module 'App'
    .controller 'main', ($scope, $timeout, $http, PriceService, GalleryService) ->
        bindArguments($scope, arguments)

        $scope.player = {}

        $scope.reviews_per_page = 10
        $scope.displayed_reviews = 3

        $scope.items_per_page = 6
        $scope.displayed_items = 6

        $scope.displayed_videos = 3
        $scope.displayed_masters = 6

        window.onYouTubeIframeAPIReady = -> $scope.videos.forEach (v) -> initVideo(v)

        $scope.initGallery = (ids, tags, folders) ->
            $http.post '/api/gallery/init', {ids: ids, tags: tags, folders: folders}
            .then (response) ->
                console.log(response.data)
                $scope.gallery = response.data

        $timeout ->
            loadReviews()
            initGmap()
            if $scope.videos then $scope.videos.forEach (v) -> initVideo(v)
            if ($scope.gallery && !isMobile) then GalleryService.init($scope.gallery)

        # REVIEWS
        $scope.loadMoreReviews = ->
            $scope.displayed_reviews += $scope.reviews_per_page

        loadReviews = ->
            params =
                folders: $scope.review_folders
                ids: $scope.review_ids
            params['tags[]'] = $scope.review_tags.split(',') if $scope.review_tags
            $http.get('/api/reviews?' + $.param(params)).then (response) ->
                $scope.reviews = response.data

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

        # остановить воспроизведение всех проигрывателей
        # except_id – кроме
        $scope.stopPlaying = (except_id) ->
            $.each $scope.player, (e, p) ->
                p.stopVideo() if (p.getPlayerState && p.getPlayerState() == 1 && p.a.id != except_id)

        initVideo = (video) ->
            return if not YT.Player or $scope.player[video.id]
            console.log("binding for video #{video.id}")
            iframe = document.getElementById("youtube-video-#{video.id}")
            requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen
            player = new YT.Player "youtube-video-#{video.id}",
                playerVars:
                    rel: 0
                events:
                    onReady: (p) ->
                        video.duration = p.target.getDuration()
                        $timeout -> $scope.$apply()
            $scope.player[video.id] = player
            $scope.player[video.id].addEventListener 'onStateChange', (state) ->
                requestFullScreen.bind(iframe)()
                $scope.stopPlaying(state.target.a.id) if state.data is YT.PlayerState.PLAYING

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

            # if isMobile
            #
            # else
            #     $scope.map.panBy(-200, 0)

            if (isMobile)
                window.onOpenModal = ->
                    google.maps.event.trigger($scope.map, 'resize')
                    $scope.map.fitBounds $scope.bounds
                    $scope.map.panToBounds $scope.bounds
