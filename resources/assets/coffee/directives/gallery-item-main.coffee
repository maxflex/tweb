angular.module 'App'
    .directive 'galleryItemMain', ->
        restrict: 'E'
        scope:
            item: '='
            service: '='
        templateUrl: '/directives/gallery-item-main'
