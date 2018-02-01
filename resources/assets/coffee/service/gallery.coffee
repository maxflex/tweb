angular.module 'App'
    .service 'GalleryService', () ->
        @displayed = 6

        @open = (index) ->
            @ctrl.open(index)

        @