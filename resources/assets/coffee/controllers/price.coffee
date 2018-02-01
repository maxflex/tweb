angular
    .module 'App'
    .controller 'price', ($scope, PriceService) ->
        bindArguments($scope, arguments)
        PriceService.expand = false