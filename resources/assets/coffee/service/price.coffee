angular.module 'App'
    .service 'PriceService', ($timeout, PriceSection) ->
        @items  = []
        @expand = true

        @get = (tags) ->
            params = {}
            params['tags[]'] = tags.split(',') if tags
            @items = PriceSection.query params, (response) =>
                if @expand then $timeout ->
                    PriceExpander.expand(if isMobile then 15 else 30)
                , 1000

        @