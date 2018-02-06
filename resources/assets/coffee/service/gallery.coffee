angular.module 'App'
    .service 'GalleryService', () ->
        el = null
        scroll_left  = null

        @open = (index) ->
            @ctrl.open(index)

        @init = ->
            el = $('.main-gallery-block')
            @screen_width = $('.main-gallery-block .gallery-item').first().outerWidth()
            # scroll_left = @screen_width - (($(window).width() - @screen_width) / 2)
            @setActive(1)

        @next = -> @setActive(@active + 1)

        @prev = -> @setActive(@active - 1)

        @setActive = (index) ->
            @active = index
            @scroll()

        @scroll = ->
            el.animate
                scrollLeft: @screen_width * @active + @screen_width - (($(window).width() - @screen_width) / 2)
            , 500, 'swing'

        @