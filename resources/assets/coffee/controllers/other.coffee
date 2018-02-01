angular
    .module 'App'
    .controller 'other', ($scope, $timeout, $filter, $http, StreamService) ->
        bindArguments($scope, arguments)
