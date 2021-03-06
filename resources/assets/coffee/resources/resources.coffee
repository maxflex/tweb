angular.module('App')
    .factory 'Master', ($resource) ->
        $resource apiPath('masters'), {id: '@id', type: '@type'},
            search:
                method: 'POST'
                url: apiPath('masters', 'search')
            reviews:
                method: 'GET'
                isArray: true
                url: apiPath('reviews')

    .factory 'Request', ($resource) ->
        $resource apiPath('requests'), {id: '@id'}, updatable()

    .factory 'Cv', ($resource) ->
        $resource apiPath('cv'), {id: '@id'}, updatable()

    .factory 'PriceSection', ($resource) ->
        $resource apiPath('prices'), {id: '@id'}, updatable()

    .factory 'PricePosition', ($resource) ->
        $resource apiPath('prices/positions'), {id: '@id'}, updatable()

    .factory 'Stream', ($resource) ->
        $resource apiPath('stream'), {id: '@id'}

apiPath = (entity, additional = '') ->
    "/api/#{entity}/" + (if additional then additional + '/' else '') + ":id"

updatable = ->
    update:
        method: 'PUT'
countable = ->
    count:
        method: 'GET'
