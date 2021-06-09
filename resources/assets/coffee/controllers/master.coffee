angular
    .module 'App'
    .controller 'master', ($scope, $timeout, $http, Master, GalleryService, DataService) ->
        bindArguments($scope, arguments)

        $scope.galleryMethods = undefined
        $scope.galleryLoadingStatus = undefined

        $scope.review = 
            hasMorePages: true
            items: undefined
            service: _.clone(DataService)
            onLoaded: (data) -> 
                $scope.review.hasMorePages = data.current_page isnt data.last_page
                if $scope.review.items is undefined
                    $scope.review.items = data.data
                else
                    $scope.review.items = $scope.review.items.concat(data.data)
        
        $scope.video = 
            hasMorePages: true
            items: undefined
            service: _.clone(DataService)
            open: (item) -> window.openVideo(item.code)
            onLoaded: (data) -> 
                $scope.video.hasMorePages = data.current_page isnt data.last_page
                if $scope.video.items is undefined
                    $scope.video.items = data.data
                else
                    $scope.video.items = $scope.video.items.concat(data.data)
        
        $scope.gallery = 
            hasMorePages: true
            items: undefined
            service: _.clone(DataService)
            open: (index) ->
                if $scope.galleryLoadingStatus is 'loaded'
                    $scope.galleryMethods.open(index)
                else
                    $scope
                        .initGallery($scope.gallery.service.args.ids, $scope.gallery.service.args.tags, $scope.gallery.service.args.folders)
                        .then -> $scope.galleryMethods.open(index)
            onLoaded: (data) -> 
                $scope.gallery.hasMorePages = data.current_page isnt data.last_page
                if $scope.gallery.items is undefined
                    $scope.gallery.items = data.data
                else
                    $scope.gallery.items = $scope.gallery.items.concat(data.data)

        $scope.initGallery = (ids, tags, folders, initGalleryBig = false) ->
            $scope.galleryLoadingStatus = 'loading'
            $http.post '/api/gallery/init', {ids: ids, tags: tags, folders: folders}
            .then (response) ->
                # $timeout ->
                $scope.images = response.data
                $scope.galleryLoadingStatus = 'loaded'
                if initGalleryBig
                    GalleryService.init(_.clone($scope.images)) 
                    $timeout ->
                        $scope.$apply()
                    , 1000
                # , 3000
        

        #
        # MOBILE
        #
        $scope.popup = (id, master = null, fn = null, index = null) ->
            openModal(id)
            if master isnt null then $scope.popup_master = master
            if fn isnt null then $timeout -> $scope[fn](master, index)
