angular.module 'App'
    .directive 'priceItem', ->
        restrict: 'E'
        templateUrl: 'directives/price-item'
        scope:
            item:   '='
        controller: ($scope, $timeout, $rootScope, PriceSection, PricePosition, Units) ->
            $scope.Units = Units
            $scope.findById = $rootScope.findById
            $scope.controller_scope = scope

            $scope.toggle = (item, event) ->
                if item.items && item.items.length
                    $(event.target).toggleClass('active')
                    $(event.target).children('.fa').first().toggleClass('fa-caret-up').toggleClass('fa-caret-down')
                    $(event.target).parent().children('ul').slideToggle(250)
