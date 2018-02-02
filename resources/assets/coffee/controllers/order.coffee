angular
    .module 'App'
    .controller 'order', ($scope, $timeout, $http, Grades, Subjects, Request, StreamService) ->
        bindArguments($scope, arguments)
        $timeout ->
            # @todo: client_id, referer, referer_url, user agent
            $scope.order = {photos: []}
            $scope.popups = {}
            $scope.agreement = true
            $scope.max_photos = 5

            $('#fileupload').fileupload
                maxFileSize: 10000000, # 10 MB
                # начало загрузки
                start: ->
                    $scope.is_uploading = true
                    $scope.$apply()
                    true
                # во время загрузки
                progress: (e, data) ->
                    $scope.uploaded_percentage = Math.round(data.loaded / data.total * 100)
                    $scope.$apply()
                # всегда по окончании загрузки (неважно, ошибка или успех)
                always: ->
                    $scope.is_uploading = false
                    $scope.$apply()
                done: (i, response) =>
                    $scope.order.photos.push(response.result)
                    $scope.$apply()

        $scope.filterPopup = (popup) ->
            $scope.popups[popup] = true

        $scope.select = (field, value) ->
            $scope.order[field] = value
            $scope.popups = {}

        $scope.photosAllowed = ->
            $scope.max_photos - $scope.order.photos.length

        $scope.request = ->
            $scope.sending = true
            $scope.errors = {}
            Request.save $scope.order, ->
                $scope.sending = false
                $scope.sent = true
                $('body').animate scrollTop: $('.header').offset().top
            , (response) ->
                $scope.sending = false
                angular.forEach response.data, (errors, field) ->
                    $scope.errors[field] = errors
                    selector = "[ng-model$='#{field}']"
                    $('html,body').animate({scrollTop: $("input#{selector}, textarea#{selector}").first().offset().top}, 0)
                    input = $("input#{selector}, textarea#{selector}")
                    input.focus()
                    input.notify errors[0], notify_options if isMobile
