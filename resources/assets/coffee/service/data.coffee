angular.module 'App'
    .service 'DataService', ($http) ->
        # начинаем со второй страницы, т.к. первую отображает SSR
        @page = 2
        @args = undefined
        @class = undefined
        @callback = undefined

        @init = (args, cls, callback) ->
            @args = args
            @class = cls
            @callback = callback

        @loadMore = () ->
            $http.post '/api/get-data', { class: @class, args: @args, page: @page }
            .then (response) =>
                @page += 1
                @callback(response.data)

        @