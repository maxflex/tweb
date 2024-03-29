angular.module 'App'
    .service 'GalleryService', () ->
        @displayed = 3

        el = null
        scroll_left  = null
        DIRECTION = {next: 1, prev: 0}
        animation_in_progress = false
        @initialized = false

        @open = (index) ->
            @ctrl.open(index)

        @init = (gallery) ->
            @gallery = gallery
            # добавляем 1 фотов конец и начало для rotate
            @gallery.push(gallery[0])
            @gallery.unshift(gallery[gallery.length - 2])
            el = $('.main-gallery-block')
            @screen_width = $('.main-gallery-block .gallery-item').first().outerWidth()
            # scroll_left = @screen_width - (($(window).width() - @screen_width) / 2)
            @setActive(1)

        @next = ->
            return if animation_in_progress
            @rotateControl(DIRECTION.next)
            @setActive(@active + 1)

        @prev = ->
            return if animation_in_progress
            @rotateControl(DIRECTION.prev)
            @setActive(@active - 1)

        @setActive = (index) ->
            @active = index
            @scroll()

        @rotateControl = (direction)->
            if @active is 1 and direction is DIRECTION.prev
                @active = @gallery.length - 1
                @scroll(0)
            if @active is @gallery.length - 2 and direction is DIRECTION.next
                @active = 0
                @scroll(0)


        @scroll = (animation_speed = 500)->
            animation_in_progress = true
            speed = if @initialized then animation_speed else 100
            el.stop().animate
                scrollLeft: @screen_width * @active + @screen_width - (($(window).width() - @screen_width) / 2)
            , speed, -> animation_in_progress = false
            @initialized = true

        @
