angular
    .module 'App'
    .controller 'master', ($scope, $timeout, $http, Master, GalleryService) ->
        bindArguments($scope, arguments)

        $scope.reviews_block = false
        $scope.gallery = []
        $scope.galleryLoaded = false
        
        $scope.initGallery = (ids, tags, folders) ->
            if ids 
                $http.post '/api/gallery/init', {ids: ids, tags: tags, folders: folders}
                .then (response) -> 
                    $scope.gallery = response.data
                    $scope.galleryLoaded = true

        # stream if index isnt null
        $scope.toggleShow = (master, prop, iteraction_type, index = null) ->
            if master[prop]
                $timeout ->
                    master[prop] = false
                , if $scope.mobile then 400 else 0
            else
                master[prop] = true
                # if index isnt false then StreamService.run iteraction_type, StreamService.identifySource(master),
                #     position: $scope.getIndex(index)
                #     master_id: master.id

        #
        # MOBILE
        #
        $scope.popup = (id, master = null, fn = null, index = null) ->
            openModal(id)
            if master isnt null then $scope.popup_master = master
            if fn isnt null then $timeout -> $scope[fn](master, index)
