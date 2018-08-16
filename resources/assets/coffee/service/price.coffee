angular.module 'App'
    .service 'PriceService', ($timeout, PriceSection) ->
        @items  = []
        @expand = true

        @get = (tags, ids, folders) ->
            params['tags[]'] = tags.split(',') if tags
            params['folders[]'] = folders.split(',') if folders
            params['ids[]'] = ids.split(',') if ids
            @items = PriceSection.query params, (response) =>
                if @expand then $timeout ->
                    PriceExpander.expand(if isMobile then 15 else 30)
                , 1000

        @
