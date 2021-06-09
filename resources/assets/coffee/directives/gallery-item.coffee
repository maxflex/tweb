angular.module 'App'
    .directive 'galleryItem', ->
        restrict: 'E'
        scope:
            item: '='
            open: '&'
        templateUrl: (elem, attrs) ->
            if isMobile then '/directives/gallery-item-mobile' else '/directives/gallery-item'
