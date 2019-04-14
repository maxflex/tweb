angular.module 'App'
    .service 'VideoService', ($timeout) ->
        window.players = {}

        # desktop
        window.player = {}

        this.init = ->
            if isMobile
                window.onYouTubeIframeAPIReady = -> initVideos()
            else
                initVideoDesktop()
        
        initVideoDesktop = ->
            window.onYouTubeIframeAPIReady = -> 
                window.player = new YT.Player('youtube-video', {})
                window.player.addEventListener "onStateChange", (state) ->
                    if state.data == YT.PlayerState.PLAYING
                        setTimeout ->
                            $('.fullscreen-loading-black').css('display', 'none')
                        , 500

            window.onCloseModal = -> player.stopVideo()

        initVideos = ->
            return if not YT.Player
            $('.youtube-video').each (i, e) ->
                id = $(e).data('id')
                iframe = document.getElementById("youtube-video-#{id}")
                requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen
                player = new YT.Player "youtube-video-#{id}",
                    playerVars:
                        rel: 0
                    events:
                        onReady: (p) ->
                            $("#video-duration-#{id}").html(getVideoDuration(p.target.getDuration()))
                            # console.log('video duration', id, p.target.getDuration())
                            # video.duration = p.target.getDuration()
                            $timeout -> scope.$apply()
                window.players[id] = player
                window.players[id].addEventListener 'onStateChange', (state) ->
                    requestFullScreen.bind(iframe)()
                    if state.data is YT.PlayerState.PLAYING
                        stopPlaying(state.target.a.id)
                return null

        # длительность видео
        getVideoDuration = (duration) -> 
            if duration
                format = if duration >= 60 then 'm:ss' else 'ss'
                moment.utc(duration * 1000).format(format)

        # остановить воспроизведение всех проигрывателей
        # except_id – кроме
        stopPlaying = (except_id) ->
            $.each window.players, (e, p) ->
                p.stopVideo() if (p.getPlayerState && p.getPlayerState() == 1 && p.a.id != except_id)

        this
