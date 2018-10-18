(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module("App", ['ngResource', 'ngAnimate', 'angular-ladda', 'angularFileUpload', 'angular-toArrayFilter', 'thatisuday.ng-image-gallery', 'ngSanitize']).config([
    'ngImageGalleryOptsProvider', function(ngImageGalleryOptsProvider) {
      return ngImageGalleryOptsProvider.setOpts({
        bubbles: true,
        bubbleSize: 165
      });
    }
  ]).config([
    '$compileProvider', function($compileProvider) {
      return $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|chrome-extension|sip):/);
    }
  ]).config(function(laddaProvider) {
    return laddaProvider.setOption({
      spinnerColor: '#83b060'
    });
  }).filter('youtubeEmbedUrl', function($sce) {
    return function(videoId) {
      return $sce.trustAsResourceUrl('https://www.youtube.com/embed/' + videoId + '?enablejsapi=1&showinfo=0&rel=0');
    };
  }).filter('cut', function() {
    return function(value, wordwise, max, tail) {
      var lastspace;
      if (tail == null) {
        tail = '';
      }
      if (!value) {
        return '';
      }
      max = parseInt(max, 10);
      if (!max) {
        return value;
      }
      if (value.length <= max) {
        return value;
      }
      value = value.substr(0, max);
      if (wordwise) {
        lastspace = value.lastIndexOf(' ');
        if (lastspace !== -1) {
          if (value.charAt(lastspace - 1) === '.' || value.charAt(lastspace - 1) === ',') {
            lastspace = lastspace - 1;
          }
          value = value.substr(0, lastspace);
        }
      }
      return value + tail;
    };
  }).filter('hideZero', function() {
    return function(item) {
      if (item > 0) {
        return item;
      } else {
        return null;
      }
    };
  }).run(function($rootScope, $q, StreamService) {
    $rootScope.streamLink = streamLink;
    $rootScope.StreamService = StreamService;
    $rootScope.dataLoaded = $q.defer();
    $rootScope.frontendStop = function(rebind_masks) {
      if (rebind_masks == null) {
        rebind_masks = true;
      }
      $rootScope.frontend_loading = false;
      $rootScope.dataLoaded.resolve(true);
      if (rebind_masks) {
        return rebindMasks();
      }
    };
    $rootScope.range = function(min, max, step) {
      var i, input;
      step = step || 1;
      input = [];
      i = min;
      while (i <= max) {
        input.push(i);
        i += step;
      }
      return input;
    };
    $rootScope.withTailingDot = function(text) {
      var char;
      text = text.trim();
      char = text[text.length - 1];
      if (['!', '.'].indexOf(char) === -1) {
        text = text + '.';
      }
      return text;
    };
    $rootScope.toggleEnum = function(ngModel, status, ngEnum, skip_values, allowed_user_ids, recursion) {
      var ref, ref1, ref2, status_id, statuses;
      if (skip_values == null) {
        skip_values = [];
      }
      if (allowed_user_ids == null) {
        allowed_user_ids = [];
      }
      if (recursion == null) {
        recursion = false;
      }
      if (!recursion && (ref = parseInt(ngModel[status]), indexOf.call(skip_values, ref) >= 0) && (ref1 = $rootScope.$$childHead.user.id, indexOf.call(allowed_user_ids, ref1) < 0)) {
        return;
      }
      statuses = Object.keys(ngEnum);
      status_id = statuses.indexOf(ngModel[status].toString());
      status_id++;
      if (status_id > (statuses.length - 1)) {
        status_id = 0;
      }
      ngModel[status] = statuses[status_id];
      if (indexOf.call(skip_values, status_id) >= 0 && (ref2 = $rootScope.$$childHead.user.id, indexOf.call(allowed_user_ids, ref2) < 0)) {
        return $rootScope.toggleEnum(ngModel, status, ngEnum, skip_values, allowed_user_ids, true);
      }
    };
    $rootScope.toggleEnumServer = function(ngModel, status, ngEnum, Resource) {
      var status_id, statuses, update_data;
      statuses = Object.keys(ngEnum);
      status_id = statuses.indexOf(ngModel[status].toString());
      status_id++;
      if (status_id > (statuses.length - 1)) {
        status_id = 0;
      }
      update_data = {
        id: ngModel.id
      };
      update_data[status] = status_id;
      return Resource.update(update_data, function() {
        return ngModel[status] = statuses[status_id];
      });
    };
    $rootScope.formatDateTime = function(date) {
      return moment(date).format("DD.MM.YY в HH:mm");
    };
    $rootScope.formatDate = function(date, full_year) {
      if (full_year == null) {
        full_year = false;
      }
      if (!date) {
        return '';
      }
      return moment(date).format("DD.MM.YY" + (full_year ? "YY" : ""));
    };
    $rootScope.formatDateFull = function(date) {
      return moment(date).format("D MMMM YYYY");
    };
    $rootScope.dialog = function(id) {
      $("#" + id).modal('show');
    };
    $rootScope.closeDialog = function(id) {
      $("#" + id).modal('hide');
    };
    $rootScope.onEnter = function(event, fun, prevent_default) {
      if (prevent_default == null) {
        prevent_default = true;
      }
      if (prevent_default) {
        event.preventDefault();
      }
      if (event.keyCode === 13) {
        return fun();
      }
    };
    $rootScope.ajaxStart = function() {
      ajaxStart();
      return $rootScope.saving = true;
    };
    $rootScope.ajaxEnd = function() {
      ajaxEnd();
      return $rootScope.saving = false;
    };
    $rootScope.findById = function(object, id) {
      return _.findWhere(object, {
        id: parseInt(id)
      });
    };
    $rootScope.total = function(array, prop, prop2) {
      var sum;
      if (prop2 == null) {
        prop2 = false;
      }
      sum = 0;
      $.each(array, function(index, value) {
        var v;
        v = value[prop];
        if (prop2) {
          v = v[prop2];
        }
        return sum += v;
      });
      return sum;
    };
    $rootScope.yearsPassed = function(year) {
      return moment().format("YYYY") - year;
    };
    $rootScope.deny = function(ngModel, prop) {
      return ngModel[prop] = +(!ngModel[prop]);
    };
    $rootScope.closestMetro = function(markers) {
      var closest_metro;
      closest_metro = markers[0].metros[0];
      markers.forEach(function(marker) {
        return marker.metros.forEach(function(metro) {
          if (metro.minutes < closest_metro.minutes) {
            return closest_metro = metro;
          }
        });
      });
      return closest_metro.station.title;
    };
    $rootScope.closestMetros = function(markers) {
      var closest_metros;
      closest_metros = [];
      markers.forEach(function(marker, index) {
        closest_metros[index] = marker.metros[0];
        return marker.metros.forEach(function(metro) {
          if (metro.minutes < closest_metros[index].minutes) {
            return closest_metros[index] = metro;
          }
        });
      });
      return closest_metros;
    };
    $rootScope.fullName = function(tutor) {
      return tutor.last_name + ' ' + tutor.first_name + ' ' + tutor.middle_name;
    };
    $rootScope.objectLength = function(obj) {
      return Object.keys(obj).length;
    };
    $rootScope.shortenGrades = function(tutor) {
      var a, combo_end, combo_start, grade_string, grades, i, j, last_grade, limit, pairs;
      if (tutor.grades.length <= 3) {
        grades = _.clone(tutor.grades);
        if (grades.length > 1) {
          last_grade = grades.pop();
        }
        grade_string = grades.join(', ');
        if (last_grade) {
          grade_string += ' и ' + last_grade;
        }
        return grade_string + (last_grade ? ' классы' : ' класс');
      } else {
        a = _.clone(tutor.grades);
        if (a.length < 1) {
          return;
        }
        limit = a.length - 1;
        combo_end = -1;
        pairs = [];
        i = 0;
        while (i <= limit) {
          combo_start = parseInt(a[i]);
          if (combo_start > 11) {
            i++;
            combo_end = -1;
            pairs.push(combo_start);
            continue;
          }
          if (combo_start <= combo_end) {
            i++;
            continue;
          }
          j = i;
          while (j <= limit) {
            combo_end = parseInt(a[j]);
            if (combo_end >= 11) {
              break;
            }
            if (parseInt(a[j + 1]) - combo_end > 1) {
              break;
            }
            j++;
          }
          if (combo_start !== combo_end) {
            pairs.push(combo_start + '–' + combo_end + ' классы');
          } else {
            pairs.push(combo_start + ' класс');
          }
          i++;
        }
        return pairs.join(', ');
      }
    };
    $rootScope.countObj = function(obj) {
      return Object.keys(obj).length;
    };
    return $rootScope.formatBytes = function(bytes) {
      if (bytes < 1024) {
        return bytes + ' Bytes';
      } else if (bytes < 1048576) {
        return (bytes / 1024).toFixed(1) + ' KB';
      } else if (bytes < 1073741824) {
        return (bytes / 1048576).toFixed(1) + ' MB';
      } else {
        return (bytes / 1073741824).toFixed(1) + ' GB';
      }
    };
  });

}).call(this);

(function() {
  window.PriceExpander = (function() {
    PriceExpander.prototype.base_class = '.price-list';

    PriceExpander.prototype.li_class = 'li:visible';

    function PriceExpander(n) {
      this.n = n;
    }

    PriceExpander.prototype._expand = function(level) {
      var expanded, i, j, ref, selector;
      if (level == null) {
        level = 1;
      }
      selector = [this.base_class];
      for (i = j = 0, ref = level - 1; 0 <= ref ? j <= ref : j >= ref; i = 0 <= ref ? ++j : --j) {
        selector.push(this.li_class);
      }
      selector = selector.join(' ');
      expanded = false;
      $(selector).each((function(_this) {
        return function(i, e) {
          if (expanded) {
            return;
          }
          e = $(e).find('>price-item>.price-section');
          e.click();
          if (_this.isExpanded()) {
            e.click();
            expanded = true;
          }
        };
      })(this));
      if (!expanded && level < 5) {
        return this._expand(level + 1);
      }
    };

    PriceExpander.prototype.getLength = function() {
      return $([this.base_class, this.li_class].join(' ')).length;
    };

    PriceExpander.prototype.isExpanded = function() {
      return this.getLength() > this.n;
    };

    PriceExpander.expand = function(n) {
      var expander;
      expander = new PriceExpander(n);
      return expander._expand();
    };

    return PriceExpander;

  })();

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('App').controller('Cv', function($scope, $timeout, $http, Subjects, Cv, StreamService) {
    var streamString;
    bindArguments($scope, arguments);
    $timeout(function() {
      $scope.cv = {};
      return $scope.sent = false;
    });
    $scope.send = function() {
      $scope.sending = true;
      $scope.errors = {};
      return Cv.save($scope.cv, function() {
        StreamService.run('tutor_cv', streamString());
        $scope.sending = false;
        $scope.sent = true;
        $('body').animate({
          scrollTop: $('.header').offset().top
        });
        return dataLayerPush({
          event: 'cv'
        });
      }, function(response) {
        $scope.sending = false;
        return angular.forEach(response.data, function(errors, field) {
          var input, selector;
          $scope.errors[field] = errors;
          selector = "[ng-model$='" + field + "']";
          $('html,body').animate({
            scrollTop: $("input" + selector + ", textarea" + selector).first().offset().top
          }, 0);
          input = $("input" + selector + ", textarea" + selector);
          input.focus();
          if (isMobile) {
            return input.notify(errors[0], notify_options);
          }
        });
      });
    };
    streamString = function() {
      var stream_string, subj;
      stream_string = [];
      if ($scope.cv.subjects) {
        subj = [];
        $scope.cv.subjects.forEach(function(subject_id) {
          return subj.push(Subjects.short_eng[subject_id]);
        });
        stream_string.push("subjects=" + subj.join('+'));
      }
      return stream_string.join('_');
    };
    $scope.isSelected = function(subject_id) {
      if (!($scope.cv && $scope.cv.subjects)) {
        return false;
      }
      return $scope.cv.subjects.indexOf(subject_id) !== -1;
    };
    $scope.selectSubject = function(subject_id) {
      if (!$scope.cv.subjects) {
        $scope.cv.subjects = [];
      }
      if ($scope.isSelected(subject_id)) {
        return $scope.cv.subjects = _.without($scope.cv.subjects, subject_id);
      } else {
        return $scope.cv.subjects.push(subject_id);
      }
    };
    return $scope.selectedSubjectsList = function() {
      var i, len, ref, ref1, ref2, subject_id, subjects;
      if (!((ref = $scope.cv) != null ? (ref1 = ref.subjects) != null ? ref1.length : void 0 : void 0)) {
        return false;
      }
      subjects = [];
      ref2 = $scope.cv.subjects;
      for (i = 0, len = ref2.length; i < len; i++) {
        subject_id = ref2[i];
        subjects.push($scope.Subjects[subject_id].name);
      }
      return subjects.join(', ');
    };
  });

}).call(this);

(function() {
  angular.module('App').controller('Gallery', function($scope, $timeout, StreamService) {
    bindArguments($scope, arguments);
    angular.element(document).ready(function() {
      $scope.all_photos = [];
      return _.each($scope.groups, function(group) {
        return $scope.all_photos = $scope.all_photos.concat(group.photo);
      });
    });
    $scope.openPhoto = function(photo_id) {
      StreamService.run('photogallery', "open_" + photo_id);
      return $scope.gallery.open($scope.getFlatIndex(photo_id));
    };
    return $scope.getFlatIndex = function(photo_id) {
      return _.findIndex($scope.all_photos, {
        id: photo_id
      });
    };
  });

}).call(this);

(function() {
  angular.module('App').controller('index', function($scope, $timeout, $http, PriceService, GalleryService) {
    var initGmap, initVideo, loadReviews, searchVideos;
    bindArguments($scope, arguments);
    $scope.player = {};
    $scope.reviews_per_page = 10;
    $scope.displayed_reviews = 3;
    $scope.items_per_page = 6;
    $scope.displayed_items = 6;
    $scope.displayed_videos = 3;
    $scope.displayed_masters = 6;
    window.onYouTubeIframeAPIReady = function() {
      return $scope.videos.forEach(function(v) {
        return initVideo(v);
      });
    };
    $timeout(function() {
      loadReviews();
      initGmap();
      $scope.videos.forEach(function(v) {
        return initVideo(v);
      });
      return GalleryService.init($scope.gallery);
    });
    $scope.loadMoreReviews = function() {
      return $scope.displayed_reviews += $scope.reviews_per_page;
    };
    loadReviews = function() {
      var params;
      params = {
        folders: $scope.review_folders,
        ids: $scope.review_ids
      };
      if ($scope.review_tags) {
        params['tags[]'] = $scope.review_tags.split(',');
      }
      return $http.get('/api/reviews?' + $.param(params)).then(function(response) {
        return $scope.reviews = response.data;
      });
    };
    $scope.nextVideosPage = function() {
      $scope.videos_page++;
      return searchVideos();
    };
    searchVideos = function() {
      $scope.searching_videos = true;
      return $http.get('/api/videos?page=' + $scope.videos_page).then(function(response) {
        $scope.searching_videos = false;
        $scope.videos = $scope.videos.concat(response.data.videos);
        $scope.has_more_videos = response.data.has_more_videos;
        return $timeout(function() {
          return response.data.videos.forEach(function(v) {
            return bindFullscreenRequest(v);
          });
        });
      });
    };
    $scope.videoDuration = function(v) {
      var format;
      if (v.duration) {
        format = v.duration >= 60 ? 'm:ss' : 'ss';
        return moment.utc(v.duration * 1000).format(format);
      }
    };
    $scope.stopPlaying = function(except_id) {
      return $.each($scope.player, function(e, p) {
        if (p.getPlayerState && p.getPlayerState() === 1 && p.a.id !== except_id) {
          return p.stopVideo();
        }
      });
    };
    initVideo = function(video) {
      var iframe, player, requestFullScreen;
      if (!YT.Player || $scope.player[video.id]) {
        return;
      }
      iframe = document.getElementById("youtube-video-" + video.id);
      requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
      player = new YT.Player("youtube-video-" + video.id, {
        playerVars: {
          rel: 0
        },
        events: {
          onReady: function(p) {
            video.duration = p.target.getDuration();
            return $timeout(function() {
              return $scope.$apply();
            });
          }
        }
      });
      $scope.player[video.id] = player;
      return $scope.player[video.id].addEventListener('onStateChange', function(state) {
        requestFullScreen.bind(iframe)();
        if (state.data === YT.PlayerState.PLAYING) {
          return $scope.stopPlaying(state.target.a.id);
        }
      });
    };
    $scope.playVideo = function() {
      var iframe, requestFullScreen;
      $scope.player.loadVideoById('qQS-d4cJr0s');
      $scope.player.playVideo();
      iframe = document.getElementById('youtube-video');
      requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
      if (requestFullScreen) {
        return requestFullScreen.bind(iframe)();
      }
    };
    $scope.openPhotoSwipe = function(index) {
      var options, pswpElement;
      $scope.items = [];
      $scope.gallery.forEach(function(g) {
        return $scope.items.push({
          src: g.url,
          msrc: g.url,
          w: 2200,
          h: 1100,
          title: g.name,
          master: g.master,
          components: g.components,
          total_price: g.total_price,
          days_to_complete: g.days_to_complete
        });
      });
      pswpElement = document.querySelectorAll('.pswp')[0];
      options = {
        getThumbBoundsFn: function(index) {
          var pageYScroll, rect, thumbnail;
          thumbnail = document.getElementById("p-" + index);
          pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
          rect = thumbnail.getBoundingClientRect();
          return {
            x: rect.left,
            y: rect.top + pageYScroll,
            w: rect.width
          };
        },
        history: false,
        focus: false,
        index: parseInt(index),
        tapToToggleControls: false,
        captionEl: false,
        arrowEl: true,
        animateTransitions: true,
        closeOnVerticalDrag: false,
        closeOnScroll: false
      };
      $scope.PhotoSwipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, $scope.items, options);
      $scope.PhotoSwipe.init();
      return $scope.PhotoSwipe.listen('preventDragEvent', function(e, isDown, preventObj) {
        return preventObj.prevent = true;
      });
    };
    $scope.initGallery = function(ids, tags, folders) {
      return $http.post('/api/gallery/init', {
        ids: ids,
        tags: tags,
        folders: folders
      }).then(function(response) {
        console.log(response.data);
        return $scope.gallery = response.data;
      });
    };
    return initGmap = function() {
      var markers;
      $scope.map = new google.maps.Map(document.getElementById("map"), {
        scrollwheel: false,
        disableDefaultUI: true,
        clickableLabels: false,
        clickableIcons: false,
        zoomControl: true,
        zoomControlOptions: {
          position: google.maps.ControlPosition.RIGHT_CENTER
        },
        scaleControl: false
      });
      $scope.bounds = new google.maps.LatLngBounds;
      markers = [newMarker(new google.maps.LatLng(55.7173112, 37.5929021), $scope.map), newMarker(new google.maps.LatLng(55.781081, 37.5141053), $scope.map)];
      markers.forEach(function(marker) {
        var marker_location;
        marker_location = new google.maps.LatLng(marker.lat, marker.lng);
        return $scope.bounds.extend(marker_location);
      });
      $scope.map.fitBounds($scope.bounds);
      $scope.map.panToBounds($scope.bounds);
      if (isMobile) {
        return window.onOpenModal = function() {
          google.maps.event.trigger($scope.map, 'resize');
          $scope.map.fitBounds($scope.bounds);
          return $scope.map.panToBounds($scope.bounds);
        };
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').constant('REVIEWS_PER_PAGE', 5).controller('Landing', function($scope, $timeout, $http, StreamService, Tutor, REVIEWS_PER_PAGE, Subjects) {
    var initTutors, searchReviews, searchTutors;
    bindArguments($scope, arguments);
    $timeout(function() {
      initYoutube();
      return initTutors();
    });
    $scope.initReviews = function(count, min_score, grade, subject, university) {
      $scope.search_reviews = {
        page: 1,
        count: count,
        min_score: min_score,
        grade: grade,
        subject: subject,
        university: university,
        ids: []
      };
      $scope.reviews = [];
      $scope.has_more_pages = true;
      return searchReviews();
    };
    $scope.nextReviewsPage = function() {
      StreamService.run('all_reviews', 'more');
      $scope.search_reviews.page++;
      return searchReviews();
    };
    searchReviews = function() {
      $scope.searching_reviews = true;
      return $http.get('/api/reviews/block?' + $.param($scope.search_reviews)).then(function(response) {
        $scope.searching_reviews = false;
        $scope.reviews = $scope.reviews.concat(response.data.reviews);
        $scope.search_reviews.ids = _.pluck($scope.reviews, 'id');
        return $scope.has_more_pages = response.data.has_more_pages;
      });
    };
    initTutors = function() {
      $scope.tutors = [];
      $scope.tutors_page = 1;
      return searchTutors();
    };
    $scope.tutorReviews = function(tutor, index) {
      StreamService.run('tutor_reviews', tutor.id);
      if (tutor.all_reviews === void 0) {
        tutor.all_reviews = Tutor.reviews({
          id: tutor.id
        }, function(response) {
          return $scope.showMoreReviews(tutor);
        });
      }
      return $scope.toggleShow(tutor, 'show_reviews', 'reviews', false);
    };
    $scope.showMoreReviews = function(tutor, index) {
      var from, to;
      tutor.reviews_page = !tutor.reviews_page ? 1 : tutor.reviews_page + 1;
      from = (tutor.reviews_page - 1) * REVIEWS_PER_PAGE;
      to = from + REVIEWS_PER_PAGE;
      return tutor.displayed_reviews = tutor.all_reviews.slice(0, to);
    };
    $scope.reviewsLeft = function(tutor) {
      var reviews_left;
      if (!tutor.all_reviews || !tutor.displayed_reviews) {
        return;
      }
      reviews_left = tutor.all_reviews.length - tutor.displayed_reviews.length;
      if (reviews_left > REVIEWS_PER_PAGE) {
        return REVIEWS_PER_PAGE;
      } else {
        return reviews_left;
      }
    };
    $scope.nextTutorsPage = function() {
      StreamService.run('load_more_tutors', $scope.tutors_page * 10);
      $scope.tutors_page++;
      return searchTutors();
    };
    searchTutors = function() {
      $scope.searching_tutors = true;
      return Tutor.search({
        page: $scope.tutors_page,
        take: 4
      }, function(response) {
        $scope.searching_tutors = false;
        $scope.tutors_data = response;
        return $scope.tutors = $scope.tutors.concat(response.data);
      });
    };
    $scope.video = function(tutor) {
      StreamService.run('tutor_video', tutor.id);
      player.loadVideoById(tutor.video_link);
      player.playVideo();
      if (isMobile) {
        $('.fullscreen-loading-black').css('display', 'flex');
      }
      return openModal('video');
    };
    $scope.videoDuration = function(tutor) {
      var duration, format;
      duration = parseInt(tutor.video_duration);
      format = duration >= 60 ? 'm мин s сек' : 's сек';
      return moment.utc(duration * 1000).format(format);
    };
    $scope.videoDurationISO = function(tutor) {
      return moment.duration(tutor.video_duration, 'seconds').toISOString();
    };
    return $scope.toggleShow = function(tutor, prop, iteraction_type, index) {
      if (index == null) {
        index = null;
      }
      if (tutor[prop]) {
        return $timeout(function() {
          return tutor[prop] = false;
        }, $scope.mobile ? 400 : 0);
      } else {
        return tutor[prop] = true;
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').controller('main', function($scope, $timeout, $http, PriceService, GalleryService) {
    var initGmap, initVideo, loadReviews, searchVideos;
    bindArguments($scope, arguments);
    $scope.player = {};
    $scope.reviews_per_page = 10;
    $scope.displayed_reviews = 3;
    $scope.items_per_page = 6;
    $scope.displayed_items = 6;
    $scope.displayed_videos = 3;
    $scope.displayed_masters = 6;
    window.onYouTubeIframeAPIReady = function() {
      return $scope.videos.forEach(function(v) {
        return initVideo(v);
      });
    };
    $scope.initGallery = function(ids, tags, folders) {
      return $http.post('/api/gallery/init', {
        ids: ids,
        tags: tags,
        folders: folders
      }).then(function(response) {
        console.log(response.data);
        return $scope.gallery = response.data;
      });
    };
    $timeout(function() {
      loadReviews();
      initGmap();
      if ($scope.videos) {
        $scope.videos.forEach(function(v) {
          return initVideo(v);
        });
      }
      if ($scope.init_gallery_service) {
        return GalleryService.init($scope.gallery);
      }
    });
    $scope.loadMoreReviews = function() {
      return $scope.displayed_reviews += $scope.reviews_per_page;
    };
    loadReviews = function() {
      var params;
      params = {
        folders: $scope.review_folders,
        ids: $scope.review_ids
      };
      if ($scope.review_tags) {
        params['tags[]'] = $scope.review_tags.split(',');
      }
      return $http.get('/api/reviews?' + $.param(params)).then(function(response) {
        return $scope.reviews = response.data;
      });
    };
    $scope.nextVideosPage = function() {
      $scope.videos_page++;
      return searchVideos();
    };
    searchVideos = function() {
      $scope.searching_videos = true;
      return $http.get('/api/videos?page=' + $scope.videos_page).then(function(response) {
        $scope.searching_videos = false;
        $scope.videos = $scope.videos.concat(response.data.videos);
        $scope.has_more_videos = response.data.has_more_videos;
        return $timeout(function() {
          return response.data.videos.forEach(function(v) {
            return bindFullscreenRequest(v);
          });
        });
      });
    };
    $scope.videoDuration = function(v) {
      var format;
      if (v.duration) {
        format = v.duration >= 60 ? 'm:ss' : 'ss';
        return moment.utc(v.duration * 1000).format(format);
      }
    };
    $scope.stopPlaying = function(except_id) {
      return $.each($scope.player, function(e, p) {
        if (p.getPlayerState && p.getPlayerState() === 1 && p.a.id !== except_id) {
          return p.stopVideo();
        }
      });
    };
    initVideo = function(video) {
      var iframe, player, requestFullScreen;
      if (!YT.Player || $scope.player[video.id]) {
        return;
      }
      console.log("binding for video " + video.id);
      iframe = document.getElementById("youtube-video-" + video.id);
      requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
      player = new YT.Player("youtube-video-" + video.id, {
        playerVars: {
          rel: 0
        },
        events: {
          onReady: function(p) {
            video.duration = p.target.getDuration();
            return $timeout(function() {
              return $scope.$apply();
            });
          }
        }
      });
      $scope.player[video.id] = player;
      return $scope.player[video.id].addEventListener('onStateChange', function(state) {
        requestFullScreen.bind(iframe)();
        if (state.data === YT.PlayerState.PLAYING) {
          return $scope.stopPlaying(state.target.a.id);
        }
      });
    };
    $scope.playVideo = function() {
      var iframe, requestFullScreen;
      $scope.player.loadVideoById('qQS-d4cJr0s');
      $scope.player.playVideo();
      iframe = document.getElementById('youtube-video');
      requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
      if (requestFullScreen) {
        return requestFullScreen.bind(iframe)();
      }
    };
    $scope.openPhotoSwipe = function(index) {
      var options, pswpElement;
      $scope.items = [];
      $scope.gallery.forEach(function(g) {
        return $scope.items.push({
          src: g.url,
          msrc: g.url,
          w: 2200,
          h: 1100,
          title: g.name,
          master: g.master,
          components: g.components,
          total_price: g.total_price,
          days_to_complete: g.days_to_complete
        });
      });
      pswpElement = document.querySelectorAll('.pswp')[0];
      options = {
        getThumbBoundsFn: function(index) {
          var pageYScroll, rect, thumbnail;
          thumbnail = document.getElementById("p-" + index);
          pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
          rect = thumbnail.getBoundingClientRect();
          return {
            x: rect.left,
            y: rect.top + pageYScroll,
            w: rect.width
          };
        },
        history: false,
        focus: false,
        index: parseInt(index),
        tapToToggleControls: false,
        captionEl: false,
        arrowEl: true,
        animateTransitions: true,
        closeOnVerticalDrag: false,
        closeOnScroll: false
      };
      $scope.PhotoSwipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, $scope.items, options);
      $scope.PhotoSwipe.init();
      return $scope.PhotoSwipe.listen('preventDragEvent', function(e, isDown, preventObj) {
        return preventObj.prevent = true;
      });
    };
    return initGmap = function() {
      var markers;
      $scope.map = new google.maps.Map(document.getElementById("map"), {
        scrollwheel: false,
        disableDefaultUI: true,
        clickableLabels: false,
        clickableIcons: false,
        zoomControl: true,
        zoomControlOptions: {
          position: google.maps.ControlPosition.RIGHT_CENTER
        },
        scaleControl: false
      });
      $scope.bounds = new google.maps.LatLngBounds;
      markers = [newMarker(new google.maps.LatLng(55.7173112, 37.5929021), $scope.map), newMarker(new google.maps.LatLng(55.781081, 37.5141053), $scope.map)];
      markers.forEach(function(marker) {
        var marker_location;
        marker_location = new google.maps.LatLng(marker.lat, marker.lng);
        return $scope.bounds.extend(marker_location);
      });
      $scope.map.fitBounds($scope.bounds);
      $scope.map.panToBounds($scope.bounds);
      if (isMobile) {
        return window.onOpenModal = function() {
          google.maps.event.trigger($scope.map, 'resize');
          $scope.map.fitBounds($scope.bounds);
          return $scope.map.panToBounds($scope.bounds);
        };
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').constant('REVIEWS_PER_PAGE', 5).controller('master', function($scope, $timeout, $http, Master, REVIEWS_PER_PAGE, GalleryService) {
    bindArguments($scope, arguments);
    $scope.initGallery = function(ids, tags, folders) {
      return $http.post('/api/gallery/init', {
        ids: ids,
        tags: tags,
        folders: folders
      }).then(function(response) {
        return $scope.gallery = response.data;
      });
    };
    $timeout(function() {
      if ($scope.masters.length % 3 === 2 && !isMobile) {
        return $scope.masters.push(null);
      }
    });
    $scope.reviews = function(master, index) {
      if (master.all_reviews === void 0) {
        master.all_reviews = Master.reviews({
          id: master.id
        }, function(response) {
          return $scope.showMoreReviews(master);
        });
      }
      return $scope.toggleShow(master, 'show_reviews', 'reviews', false);
    };
    $scope.showMoreReviews = function(master, index) {
      var from, to;
      master.reviews_page = !master.reviews_page ? 1 : master.reviews_page + 1;
      from = (master.reviews_page - 1) * REVIEWS_PER_PAGE;
      to = from + REVIEWS_PER_PAGE;
      return master.displayed_reviews = master.all_reviews.slice(0, to);
    };
    $scope.reviewsLeft = function(master) {
      var reviews_left;
      if (!master.all_reviews || !master.displayed_reviews) {
        return;
      }
      reviews_left = master.all_reviews.length - master.displayed_reviews.length;
      if (reviews_left > REVIEWS_PER_PAGE) {
        return REVIEWS_PER_PAGE;
      } else {
        return reviews_left;
      }
    };
    $scope.toggleShow = function(master, prop, iteraction_type, index) {
      if (index == null) {
        index = null;
      }
      if (master[prop]) {
        return $timeout(function() {
          return master[prop] = false;
        }, $scope.mobile ? 400 : 0);
      } else {
        return master[prop] = true;
      }
    };
    return $scope.popup = function(id, master, fn, index) {
      if (master == null) {
        master = null;
      }
      if (fn == null) {
        fn = null;
      }
      if (index == null) {
        index = null;
      }
      openModal(id);
      if (master !== null) {
        $scope.popup_master = master;
      }
      if (fn !== null) {
        return $timeout(function() {
          return $scope[fn](master, index);
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').controller('order', function($scope, $timeout, $http, Grades, Subjects, Request, StreamService) {
    bindArguments($scope, arguments);
    $timeout(function() {
      $scope.order = {
        photos: []
      };
      $scope.popups = {};
      $scope.agreement = true;
      $scope.max_photos = 5;
      return $('#fileupload').fileupload({
        maxFileSize: 5000000,
        send: function(e, data) {
          if (data.files[0].size > 5242880) {
            $scope.upload_error = 'максимальный объём файла – 5 Мб';
            $scope.$apply();
            return false;
          }
          $scope.upload_error = null;
          $scope.order.photos.push(null);
          return $scope.$apply();
        },
        progress: function(e, data) {
          $scope.uploaded_percentage = Math.round(data.loaded / data.total * 100);
          return $scope.$apply();
        },
        done: (function(_this) {
          return function(i, response) {
            if (response.result.hasOwnProperty('error')) {
              $scope.upload_error = response.result.error;
            } else {
              $scope.order.photos[$scope.order.photos.length - 1] = response.result;
            }
            return $scope.$apply();
          };
        })(this)
      });
    });
    $scope.photoUploading = function() {
      return $scope.order.photos[$scope.order.photos.length - 1] === null;
    };
    $scope.filterPopup = function(popup) {
      return $scope.popups[popup] = true;
    };
    $scope.select = function(field, value) {
      $scope.order[field] = value;
      return $scope.popups = {};
    };
    $scope.photosAllowed = function() {
      return $scope.max_photos - $scope.order.photos.length;
    };
    $scope.fileChange = function(event) {
      return console.log(event);
    };
    return $scope.request = function() {
      $scope.sending = true;
      $scope.errors = {};
      return Request.save($scope.order, function() {
        $scope.sending = false;
        $scope.sent = true;
        return $('body').animate({
          scrollTop: $('.header').offset().top
        });
      }, function(response) {
        $scope.sending = false;
        return angular.forEach(response.data, function(errors, field) {
          var input, selector;
          $scope.errors[field] = errors;
          selector = "[ng-model$='" + field + "']";
          $('html,body').animate({
            scrollTop: $("input" + selector + ", textarea" + selector).first().offset().top
          }, 0);
          input = $("input" + selector + ", textarea" + selector);
          input.focus();
          if (isMobile) {
            return input.notify(errors[0], notify_options);
          }
        });
      });
    };
  });

}).call(this);

(function() {
  angular.module('App').controller('other', function($scope, $timeout, $filter, $http, StreamService) {
    return bindArguments($scope, arguments);
  });

}).call(this);

(function() {
  angular.module('App').controller('price', function($scope, PriceService) {
    bindArguments($scope, arguments);
    return PriceService.expand = false;
  });

}).call(this);

(function() {
  angular.module('App').constant('REVIEWS_PER_PAGE', 5).controller('Reviews', function($scope, $timeout, $http, Subjects, StreamService) {
    var search;
    bindArguments($scope, arguments);
    $timeout(function() {
      $scope.reviews = [];
      $scope.page = 1;
      $scope.has_more_pages = true;
      return search();
    });
    $scope.popup = function(index) {
      return $scope.show_review = index;
    };
    $scope.nextPage = function() {
      StreamService.run('all_reviews', 'more');
      $scope.page++;
      return search();
    };
    return search = function() {
      $scope.searching = true;
      return $http.get('/api/reviews?page=' + $scope.page).then(function(response) {
        console.log(response);
        $scope.searching = false;
        $scope.reviews = $scope.reviews.concat(response.data.reviews);
        return $scope.has_more_pages = response.data.has_more_pages;
      });
    };
  });

}).call(this);

(function() {
  angular.module('App').constant('REVIEWS_PER_PAGE', 5).controller('Tutors', function($scope, $timeout, $http, Tutor, REVIEWS_PER_PAGE, Subjects, StreamService) {
    var filter, filter_used, search, search_count;
    bindArguments($scope, arguments);
    initYoutube();
    $scope.popups = {};
    $scope.filterPopup = function(popup) {
      return $scope.popups[popup] = true;
    };
    search_count = 0;
    $scope.profilePage = function() {
      return RegExp(/^\/tutors\/[\d]+$/).test(window.location.pathname);
    };
    $timeout(function() {
      $scope.search = {};
      if (!$scope.profilePage()) {
        return $scope.filter();
      }
    });
    $scope.selectSubject = function(id) {
      $scope.search.subject_id = id;
      $scope.popups = {};
      return $scope.subjectChanged();
    };
    $scope.reviews = function(tutor, index) {
      StreamService.run('tutor_reviews', tutor.id);
      if (tutor.all_reviews === void 0) {
        tutor.all_reviews = Tutor.reviews({
          id: tutor.id
        }, function(response) {
          return $scope.showMoreReviews(tutor);
        });
      }
      return $scope.toggleShow(tutor, 'show_reviews', 'reviews', false);
    };
    $scope.showMoreReviews = function(tutor, index) {
      var from, to;
      tutor.reviews_page = !tutor.reviews_page ? 1 : tutor.reviews_page + 1;
      from = (tutor.reviews_page - 1) * REVIEWS_PER_PAGE;
      to = from + REVIEWS_PER_PAGE;
      return tutor.displayed_reviews = tutor.all_reviews.slice(0, to);
    };
    $scope.reviewsLeft = function(tutor) {
      var reviews_left;
      if (!tutor.all_reviews || !tutor.displayed_reviews) {
        return;
      }
      reviews_left = tutor.all_reviews.length - tutor.displayed_reviews.length;
      if (reviews_left > REVIEWS_PER_PAGE) {
        return REVIEWS_PER_PAGE;
      } else {
        return reviews_left;
      }
    };
    $scope.subjectChanged = function() {
      StreamService.run('choose_tutor_subject', Subjects.short_eng[$scope.search.subject_id]);
      return $scope.filter();
    };
    filter_used = false;
    $scope.filter = function() {
      $scope.tutors = [];
      $scope.page = 1;
      if (filter_used) {
        return filter();
      } else {
        filter();
        return filter_used = true;
      }
    };
    filter = function() {
      return search();
    };
    $scope.nextPage = function() {
      StreamService.run('load_more_tutors', $scope.page * 10);
      $scope.page++;
      return search();
    };
    search = function() {
      $scope.searching = true;
      return Tutor.search({
        filter_used: filter_used,
        page: $scope.page,
        search: $scope.search
      }, function(response) {
        search_count++;
        $scope.searching = false;
        $scope.data = response;
        return $scope.tutors = $scope.tutors.concat(response.data);
      });
    };
    $scope.video = function(tutor) {
      StreamService.run('tutor_video', tutor.id);
      player.loadVideoById(tutor.video_link);
      player.playVideo();
      if (isMobile) {
        $('.fullscreen-loading-black').css('display', 'flex');
      }
      return openModal('video');
    };
    $scope.videoDuration = function(tutor) {
      var duration, format;
      duration = parseInt(tutor.video_duration);
      format = duration >= 60 ? 'm мин s сек' : 's сек';
      return moment.utc(duration * 1000).format(format);
    };
    $scope.videoDurationISO = function(tutor) {
      return moment.duration(tutor.video_duration, 'seconds').toISOString();
    };
    $scope.toggleShow = function(tutor, prop, iteraction_type, index) {
      if (index == null) {
        index = null;
      }
      if (tutor[prop]) {
        return $timeout(function() {
          return tutor[prop] = false;
        }, $scope.mobile ? 400 : 0);
      } else {
        return tutor[prop] = true;
      }
    };
    return $scope.popup = function(id, tutor, fn, index) {
      if (tutor == null) {
        tutor = null;
      }
      if (fn == null) {
        fn = null;
      }
      if (index == null) {
        index = null;
      }
      openModal(id);
      if (tutor !== null) {
        $scope.popup_tutor = tutor;
      }
      if (fn !== null) {
        return $timeout(function() {
          return $scope[fn](tutor, index);
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').value('AvgScores', {
    '1-11-1': 46.3,
    '2-11': 51.2,
    '3-11': 56.1,
    '4-11': 52.8,
    '5-11': 53,
    '6-11': 65.8,
    '7-11': 56,
    '8-11': 53.3,
    '9-11': 48.1,
    '10-11': 64.2,
    '11-11': 53
  }).value('Units', [
    {
      id: 1,
      title: 'изделие'
    }, {
      id: 2,
      title: 'штука'
    }, {
      id: 3,
      title: 'сантиметр'
    }, {
      id: 4,
      title: 'пара'
    }, {
      id: 5,
      title: 'метр'
    }, {
      id: 6,
      title: 'дм²'
    }, {
      id: 7,
      title: 'см²'
    }, {
      id: 8,
      title: 'мм²'
    }, {
      id: 9,
      title: 'элемент'
    }
  ]).value('Grades', {
    9: '9 класс',
    10: '10 класс',
    11: '11 класс'
  }).value('Subjects', {
    all: {
      1: 'математика',
      2: 'физика',
      3: 'химия',
      4: 'биология',
      5: 'информатика',
      6: 'русский',
      7: 'литература',
      8: 'обществознание',
      9: 'история',
      10: 'английский',
      11: 'география'
    },
    full: {
      1: 'Математика',
      2: 'Физика',
      3: 'Химия',
      4: 'Биология',
      5: 'Информатика',
      6: 'Русский язык',
      7: 'Литература',
      8: 'Обществознание',
      9: 'История',
      10: 'Английский язык',
      11: 'География'
    },
    dative: {
      1: 'математике',
      2: 'физике',
      3: 'химии',
      4: 'биологии',
      5: 'информатике',
      6: 'русскому языку',
      7: 'литературе',
      8: 'обществознанию',
      9: 'истории',
      10: 'английскому языку',
      11: 'географии'
    },
    short: ['М', 'Ф', 'Р', 'Л', 'А', 'Ис', 'О', 'Х', 'Б', 'Ин', 'Г'],
    three_letters: {
      1: 'МАТ',
      2: 'ФИЗ',
      3: 'ХИМ',
      4: 'БИО',
      5: 'ИНФ',
      6: 'РУС',
      7: 'ЛИТ',
      8: 'ОБЩ',
      9: 'ИСТ',
      10: 'АНГ',
      11: 'ГЕО'
    },
    short_eng: {
      1: 'math',
      2: 'phys',
      3: 'chem',
      4: 'bio',
      5: 'inf',
      6: 'rus',
      7: 'lit',
      8: 'soc',
      9: 'his',
      10: 'eng',
      11: 'geo'
    }
  });

}).call(this);

(function() {
  var apiPath, countable, updatable;

  angular.module('App').factory('Master', function($resource) {
    return $resource(apiPath('masters'), {
      id: '@id',
      type: '@type'
    }, {
      search: {
        method: 'POST',
        url: apiPath('masters', 'search')
      },
      reviews: {
        method: 'GET',
        isArray: true,
        url: apiPath('reviews')
      }
    });
  }).factory('Request', function($resource) {
    return $resource(apiPath('requests'), {
      id: '@id'
    }, updatable());
  }).factory('Cv', function($resource) {
    return $resource(apiPath('cv'), {
      id: '@id'
    }, updatable());
  }).factory('PriceSection', function($resource) {
    return $resource(apiPath('prices'), {
      id: '@id'
    }, updatable());
  }).factory('PricePosition', function($resource) {
    return $resource(apiPath('prices/positions'), {
      id: '@id'
    }, updatable());
  }).factory('Stream', function($resource) {
    return $resource(apiPath('stream'), {
      id: '@id'
    });
  });

  apiPath = function(entity, additional) {
    if (additional == null) {
      additional = '';
    }
    return ("/api/" + entity + "/") + (additional ? additional + '/' : '') + ":id";
  };

  updatable = function() {
    return {
      update: {
        method: 'PUT'
      }
    };
  };

  countable = function() {
    return {
      count: {
        method: 'GET'
      }
    };
  };

}).call(this);

(function() {
  angular.module('App').directive('academic', function() {
    return {
      restrict: 'E',
      template: "{{ year }}–{{ +(year) + 1 }}",
      scope: {
        year: '='
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').directive('digitsOnly', function() {
    return {
      restrics: 'A',
      require: 'ngModel',
      link: function($scope, $element, $attr, $ctrl) {
        var filter, ref;
        filter = function(value) {
          var new_value;
          if (!value) {
            return void 0;
          }
          new_value = value.replace(/[^0-9]/g, '');
          if (new_value !== value) {
            $ctrl.$setViewValue(new_value);
            $ctrl.$render();
          }
          return value;
        };
        return (ref = $ctrl.$parsers) != null ? ref.push(filter) : void 0;
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').directive('errors', function() {
    return {
      restrict: 'E',
      templateUrl: '/directives/errors',
      scope: {
        model: '@'
      },
      controller: function($scope, $element, $attrs) {
        $scope.only_first = $attrs.hasOwnProperty('onlyFirst');
        return $scope.getErrors = function() {
          var errors;
          if ($scope.$parent.errors === void 0) {
            return;
          }
          errors = $scope.$parent.errors[$scope.model];
          if (!errors) {
            return;
          }
          if ($scope.only_first) {
            return [errors[0]];
          } else {
            return errors;
          }
        };
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('App').directive('ngMark', function() {
    return {
      restrict: 'A',
      scope: {
        word: '@'
      },
      controller: function($scope, $element, $attrs, $timeout) {
        return $timeout(function() {
          return $($element).mark($scope.word, {
            separateWordSearch: true,
            accuracy: {
              value: 'exactly',
              limiters: ['!', '@', '#', '&', '*', '(', ')', '-', '–', '—', '+', '=', '[', ']', '{', '}', '|', ':', ';', '\'', '\"', '‘', '’', '“', '”', ',', '.', '<', '>', '/', '?']
            }
          });
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').directive('ngPhone', function() {
    return {
      restrict: 'A',
      link: function($scope, element) {
        return $(element).inputmask("+7 (999) 999-99-99", {
          autoclear: false,
          showMaskOnHover: false
        });
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').directive('plural', function() {
    return {
      restrict: 'E',
      scope: {
        count: '=',
        type: '@',
        noneText: '@'
      },
      templateUrl: '/directives/plural',
      controller: function($scope, $element, $attrs, $timeout) {
        $scope.textOnly = $attrs.hasOwnProperty('textOnly');
        $scope.hideZero = $attrs.hasOwnProperty('hideZero');
        return $scope.when = {
          'age': ['год', 'года', 'лет'],
          'student': ['ученик', 'ученика', 'учеников'],
          'minute': ['минуту', 'минуты', 'минут'],
          'hour': ['час', 'часа', 'часов'],
          'day': ['день', 'дня', 'дней'],
          'rubbles': ['рубль', 'рубля', 'рублей'],
          'client': ['клиент', 'клиента', 'клиентов'],
          'mark': ['оценки', 'оценок', 'оценок'],
          'review': ['отзыв', 'отзыва', 'отзывов'],
          'request': ['заявка', 'заявки', 'заявок'],
          'profile': ['анкета', 'анкеты', 'анкет'],
          'address': ['адрес', 'адреса', 'адресов'],
          'person': ['человек', 'человека', 'человек'],
          'ton': ['тонна', 'тонны', 'тонн'],
          'yacht': ['яхта', 'яхты', 'яхт'],
          'photo': ['фото', 'фотографии', 'фотографий']
        };
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').directive('priceItem', function() {
    return {
      restrict: 'E',
      templateUrl: function(elem, attrs) {
        if (isMobile) {
          return '/directives/price-item-mobile';
        } else {
          return '/directives/price-item';
        }
      },
      scope: {
        item: '=',
        level: '='
      },
      controller: function($scope, $timeout, $rootScope, PriceSection, PricePosition, Units) {
        $scope.Units = Units;
        $scope.findById = $rootScope.findById;
        $scope.controller_scope = scope;
        $scope.priceRounded = function(price) {
          return Math.round(price / 10) * 10;
        };
        $scope.getStyle = function() {
          var offset;
          offset = $scope.level * 20 + 'px';
          return {
            left: offset,
            width: "calc(100% - " + offset + ")"
          };
        };
        return $scope.toggle = function(item, event) {
          if (item.items && item.items.length) {
            $(event.target).toggleClass('active');
            return $(event.target).parent().children('ul').slideToggle(250);
          }
        };
      }
    };
  });

}).call(this);

(function() {
  angular.module('App').directive('programItem', function() {
    return {
      templateUrl: '/directives/program',
      scope: {
        item: '=',
        level: '=?',
        levelstring: '='
      },
      controller: function($timeout, $element, $scope) {
        if (!$scope.level) {
          $scope.level = 0;
        }
        return $scope.getChildLevelString = function(child_index) {
          var str;
          str = $scope.levelstring ? $scope.levelstring : '';
          return str + (child_index + 1) + '.';
        };
      }
    };
  });

}).call(this);

(function() {


}).call(this);

(function() {
  angular.module('App').service('GalleryService', function() {
    var DIRECTION, animation_in_progress, el, scroll_left;
    this.displayed = 6;
    el = null;
    scroll_left = null;
    DIRECTION = {
      next: 1,
      prev: 0
    };
    animation_in_progress = false;
    this.open = function(index) {
      return this.ctrl.open(index);
    };
    this.init = function(gallery) {
      this.gallery = gallery;
      this.gallery.push(gallery[0]);
      this.gallery.unshift(gallery[gallery.length - 2]);
      el = $('.main-gallery-block');
      this.screen_width = $('.main-gallery-block .gallery-item').first().outerWidth();
      return this.setActive(1);
    };
    this.next = function() {
      if (animation_in_progress) {
        return;
      }
      this.rotateControl(DIRECTION.next);
      return this.setActive(this.active + 1);
    };
    this.prev = function() {
      if (animation_in_progress) {
        return;
      }
      this.rotateControl(DIRECTION.prev);
      return this.setActive(this.active - 1);
    };
    this.setActive = function(index) {
      this.active = index;
      return this.scroll();
    };
    this.rotateControl = function(direction) {
      if (this.active === 1 && direction === DIRECTION.prev) {
        this.active = this.gallery.length - 1;
        this.scroll(0);
      }
      if (this.active === this.gallery.length - 2 && direction === DIRECTION.next) {
        this.active = 0;
        return this.scroll(0);
      }
    };
    this.scroll = function(animation_speed) {
      if (animation_speed == null) {
        animation_speed = 500;
      }
      animation_in_progress = true;
      return el.stop().animate({
        scrollLeft: this.screen_width * this.active + this.screen_width - (($(window).width() - this.screen_width) / 2)
      }, animation_speed, function() {
        return animation_in_progress = false;
      });
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('App').service('PhoneService', function() {
    var isFull;
    this.checkForm = function(element) {
      var phone_element, phone_number;
      phone_element = $(element).find('.phone-field');
      if (!isFull(phone_element.val())) {
        phone_element.focus().notify('номер телефона не заполнен полностью', notify_options);
        return false;
      }
      phone_number = phone_element.val().match(/\d/g).join('');
      if (phone_number[1] !== '4' && phone_number[1] !== '9') {
        phone_element.focus().notify('номер должен начинаться с 9 или 4', notify_options);
        return false;
      }
      return true;
    };
    isFull = function(number) {
      if (number === void 0 || number === "") {
        return false;
      }
      return !number.match(/_/);
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('App').service('PriceService', function($timeout, PriceSection) {
    this.items = [];
    this.expand = true;
    this.get = function(tags, ids, folders) {
      var params;
      params = {};
      if (tags) {
        params['tags[]'] = tags.split(',');
      }
      if (folders && folders !== '{folders}') {
        params['folders[]'] = folders.split(',');
      }
      if (ids && ids !== '{ids}') {
        params['ids[]'] = ids.split(',');
      }
      return this.items = PriceSection.query(params, (function(_this) {
        return function(response) {
          if (_this.expand) {
            return $timeout(function() {
              return PriceExpander.expand(isMobile ? 15 : 30);
            }, 1000);
          }
        };
      })(this));
    };
    return this;
  });

}).call(this);

(function() {
  angular.module('App').service('StreamService', function($http, $timeout, Stream) {
    this.identifySource = function(tutor) {
      if (tutor == null) {
        tutor = void 0;
      }
      if (tutor !== void 0 && tutor.is_similar) {
        return 'similar';
      }
      if (RegExp(/^\/[\d]+$/).test(window.location.pathname)) {
        return 'tutor';
      }
      if (window.location.pathname === '/request') {
        return 'help';
      }
      if (window.location.pathname === '/') {
        return 'main';
      }
      return 'serp';
    };
    this.generateEventString = function(params) {
      var parts, search;
      search = $.cookie('search');
      if (search !== void 0) {
        $.each(JSON.parse(search), function(key, value) {
          return params[key] = value;
        });
      }
      parts = [];
      $.each(params, function(key, value) {
        var where;
        switch (key) {
          case 'sort':
            switch (parseInt(value)) {
              case 2:
                value = 'maxprice';
                break;
              case 3:
                value = 'minprice';
                break;
              case 4:
                value = 'rating';
                break;
              case 5:
                value = 'bymetro';
                break;
              default:
                value = 'pop';
            }
            break;
          case 'place':
            switch (parseInt(params.place)) {
              case 1:
                where = 'tutor';
                break;
              case 2:
                where = 'client';
                break;
              default:
                where = 'any';
            }
        }
        if ((key === 'action' || key === 'type' || key === 'google_id' || key === 'yandex_id' || key === 'id' || key === 'hidden_filter') || !value) {
          return;
        }
        return parts.push(key + '=' + value);
      });
      return parts.join('_');
    };
    this.updateCookie = function(params) {
      if (this.cookie === void 0) {
        this.cookie = {};
      }
      $.each(params, (function(_this) {
        return function(key, value) {
          return _this.cookie[key] = value;
        };
      })(this));
      return $.cookie('stream', JSON.stringify(this.cookie), {
        expires: 365,
        path: '/'
      });
    };
    this.initCookie = function() {
      if ($.cookie('stream') !== void 0) {
        return this.cookie = JSON.parse($.cookie('stream'));
      } else {
        return this.updateCookie({
          step: 0,
          search: 0
        });
      }
    };
    this.run = function(action, type, additional) {
      if (additional == null) {
        additional = {};
      }
      if (this.cookie === void 0) {
        this.initCookie();
      }
      if (!this.initialized) {
        return $timeout((function(_this) {
          return function() {
            return _this._run(action, type, additional);
          };
        })(this), 1000);
      } else {
        return this._run(action, type, additional);
      }
    };
    this._run = function(action, type, additional) {
      var params;
      if (additional == null) {
        additional = {};
      }
      this.updateCookie({
        step: this.cookie.step + 1
      });
      params = {
        action: action,
        type: type,
        step: this.cookie.step,
        mobile: typeof isMobile === 'undefined' ? '0' : '1'
      };
      $.each(additional, (function(_this) {
        return function(key, value) {
          return params[key] = value;
        };
      })(this));
      if (action !== 'page') {
        dataLayerPush({
          event: 'configuration',
          eventCategory: action,
          eventAction: type
        });
      }
      return Stream.save(params).$promise;
    };
    return this;
  });

}).call(this);

//# sourceMappingURL=app.js.map
