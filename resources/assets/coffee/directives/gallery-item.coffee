angular.module 'App'
    .directive 'galleryItem', ->
        restrict: 'E'
        scope:
            item: '='
            service: '='
            index: '='
        templateUrl: (elem, attrs) ->
            if isMobile then '/directives/gallery-item-mobile' else '/directives/gallery-item'
