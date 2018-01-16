angular.module 'App'
    .directive 'priceItem', ->
        restrict: 'E'
        templateUrl: '/directives/price-item'
        scope:
            item:   '='
        controller: ($scope, $timeout, $rootScope, PriceSection, PricePosition, Units) ->
            $scope.Units = Units
            $scope.findById = $rootScope.findById
            $scope.controller_scope = scope

            $scope.priceRounded = (price) -> Math.round(price / 10) * 10

            $scope.toggle = (item, event) ->
                if item.items && item.items.length
                    $(event.target).toggleClass('active')
                    $(event.target).parent().children('ul').slideToggle(250)
