angular.module 'App'
    .directive 'reviewItem', ->
        restrict: 'E'
        templateUrl: ->
            if isMobile then '/directives/review-item-mobile' else '/directives/review-item'
        scope:
            item:   '='
