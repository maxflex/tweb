angular.module 'App'
    .directive 'galleryItem', ->
        restrict: 'E'
        scope:
            item: '='
            open: '&'
            altt: '@'
        templateUrl: (elem, attrs) ->
            if isMobile then '/directives/gallery-item-mobile' else '/directives/gallery-item'
