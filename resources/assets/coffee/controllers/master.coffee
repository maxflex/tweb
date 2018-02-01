angular
    .module 'App'
    .constant 'REVIEWS_PER_PAGE', 5
    .controller 'master', ($scope, $timeout, $http, Master, REVIEWS_PER_PAGE, GalleryService) ->
        bindArguments($scope, arguments)

        $scope.reviews = (master, index) ->
            # StreamService.run('master_reviews', master.id)
            #     position: $scope.getIndex(index)
            #     master_id: master.id
            if master.all_reviews is undefined
                master.all_reviews = Master.reviews
                    id: master.id
                , (response) ->
                    $scope.showMoreReviews(master)
            $scope.toggleShow(master, 'show_reviews', 'reviews', false)

        $scope.showMoreReviews = (master, index) ->
            # if master.reviews_page then StreamService.run 'reviews_more', StreamService.identifySource(master),
            #     position: $scope.getIndex(index)
            #     master_id: master.id
            #     depth: (master.reviews_page + 1) * REVIEWS_PER_PAGE
            master.reviews_page = if not master.reviews_page then 1 else (master.reviews_page + 1)
            from = (master.reviews_page - 1) * REVIEWS_PER_PAGE
            to = from + REVIEWS_PER_PAGE
            master.displayed_reviews = master.all_reviews.slice(0, to)
            # highlight('search-result-reviews-text')

        $scope.reviewsLeft = (master) ->
            return if not master.all_reviews or not master.displayed_reviews
            reviews_left = master.all_reviews.length - master.displayed_reviews.length
            if reviews_left > REVIEWS_PER_PAGE then REVIEWS_PER_PAGE else reviews_left

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