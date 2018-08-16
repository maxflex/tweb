angular.module 'App'
    .service 'PriceService', ($timeout, PriceSection) ->
        @items  = []
        @expand = true

        @get = (tags, ids, folders) ->
            params = {}
            params['tags[]'] = tags.split(',') if tags
            params['folders[]'] = folders.split(',') if folders && folders isnt '{folders}'
            params['ids[]'] = ids.split(',') if ids && ids isnt '{ids}'
            @items = PriceSection.query params, (response) =>
                if @expand then $timeout ->
                    PriceExpander.expand(if isMobile then 15 else 30)
                , 1000

        @
