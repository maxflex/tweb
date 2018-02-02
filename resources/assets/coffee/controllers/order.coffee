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
                maxFileSize: 5000000
                # начало загрузки
                send: (e, data) ->
                    if data.files[0].size > 5242880
                        $scope.upload_error = 'максимальный объём файла – 5 Мб'
                        $scope.$apply()
                        return false
                    $scope.upload_error = null
                    $scope.order.photos.push(null)
                    $scope.$apply()
                # start: ->
                #     $scope.order.photos.push(null)
                #     $scope.upload_error = null
                #     $scope.$apply()
                #     true
                # во время загрузки
                progress: (e, data) ->
                    $scope.uploaded_percentage = Math.round(data.loaded / data.total * 100)
                    $scope.$apply()
                # всегда по окончании загрузки (неважно, ошибка или успех)
                # always: ->
                #     $scope.is_uploading = false
                #     $scope.$apply()
                done: (i, response) =>
                    if response.result.hasOwnProperty('error')
                        $scope.upload_error = response.result.error
                    else
                        $scope.order.photos[$scope.order.photos.length - 1] = response.result
                    $scope.$apply()

        $scope.photoUploading = -> $scope.order.photos[$scope.order.photos.length - 1] is null

        $scope.filterPopup = (popup) ->
            $scope.popups[popup] = true

        $scope.select = (field, value) ->
            $scope.order[field] = value
            $scope.popups = {}

        $scope.photosAllowed = ->
            $scope.max_photos - $scope.order.photos.length

        $scope.fileChange = (event) ->
            console.log(event)

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
