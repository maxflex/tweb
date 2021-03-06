angular.module 'App'
    .directive 'priceItem', ->
        restrict: 'E'
        # templateUrl: '/directives/price-item'
        templateUrl: (elem, attrs) ->
            if isMobile then '/directives/price-item-mobile' else '/directives/price-item'
        scope:
            item:   '='
            level: '='
        controller: ($scope, $timeout, $rootScope, PriceSection, PricePosition, Units) ->
            $scope.Units = Units
            $scope.findById = $rootScope.findById
            $scope.controller_scope = scope

            $scope.priceRounded = (price) -> Math.round(price / 10) * 10

            $scope.getStyle = ->
                offset = $scope.level * 20 + 'px'
                left: offset
                width: "calc(100% - #{offset})"

            $scope.toggle = (item, event) ->
                if item.items && item.items.length
                    # IE fix
                    target = if $(event.target).hasClass('price-line') then $(event.target) else $(event.target).closest('.price-line')
                    target.toggleClass('active')
                    ul = target.parent().children('ul')
                    event_name = if ul.is(':visible') then prefixEvent('price-minimize') else prefixEvent('price-expand')
                    eventAction(event_name, item.model.name)
                    ul.slideToggle(250)
