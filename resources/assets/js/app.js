(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  angular.module("App", ['ngResource', 'ngAnimate', 'angular-ladda', 'angularFileUpload', 'angular-toArrayFilter', 'thatisuday.ng-image-gallery', 'thatisuday.ng-image-gallery-2', 'ngSanitize']).config([
    'ngImageGalleryOptsProvider', function(ngImageGalleryOptsProvider) {
      return ngImageGalleryOptsProvider.setOpts({
        bubbles: true,
        bubbleSize: 165
      });
    }
  ]).config([
    'ngImageGalleryOpts2Provider', function(ngImageGalleryOpts2Provider) {
      return ngImageGalleryOpts2Provider.setOpts({
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
    $rootScope.eventUrl = eventUrl;
    $rootScope.eventAction = eventAction;
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
    PriceExpander.prototype.base_class = '.price-list:visible';

    PriceExpander.prototype.li_class = 'li';

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
          e = $(e).children().children('.price-section');
          if (e.length > 0) {
            console.log('clicking on ', e);
            console.log('selector', selector);
            console.log("Length: ", _this.getLength(), _this.isExpanded(), expanded);
            if (!e.parent().children('ul').is(':visible')) {
              e.click();
              if (_this.isExpanded()) {
                expanded = true;
              }
            }
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
  angular.module('App').controller('main', function($scope, $timeout, $http, GalleryService) {
    var initGmap;
    bindArguments($scope, arguments);
    $scope.galleryLoaded = false;
    $scope.GalleryService2 = _.clone(GalleryService);
    $scope.initGallery = function(ids, tags, folders, isFirst, initGallery) {
      if (isFirst == null) {
        isFirst = true;
      }
      if (initGallery == null) {
        initGallery = false;
      }
      return $http.post('/api/gallery/init', {
        ids: ids,
        tags: tags,
        folders: folders
      }).then(function(response) {
        if (isFirst) {
          $scope.gallery = response.data;
        }
        if (!isFirst) {
          $scope.gallery2 = response.data;
        }
        $scope.galleryLoaded = true;
        if (initGallery) {
          GalleryService.init(_.clone($scope.gallery));
          return $timeout(function() {
            return $scope.$apply();
          }, 1000);
        }
      });
    };
    $timeout(function() {
      PriceExpander.expand(isMobile ? 15 : 30);
      return initGmap();
    });
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
      markers = [newMarker(new google.maps.LatLng(55.717295, 37.595088), $scope.map), newMarker(new google.maps.LatLng(55.781302, 37.516045), $scope.map), newMarker(new google.maps.LatLng(55.776497, 37.614389), $scope.map)];
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
  angular.module('App').controller('master', function($scope, $timeout, $http, Master, GalleryService) {
    bindArguments($scope, arguments);
    $scope.reviews_block = false;
    $scope.gallery = [];
    $scope.galleryLoaded = false;
    $scope.initGallery = function(ids, tags, folders) {
      if (ids) {
        return $http.post('/api/gallery/init', {
          ids: ids,
          tags: tags,
          folders: folders
        }).then(function(response) {
          $scope.gallery = response.data;
          return $scope.galleryLoaded = true;
        });
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
  angular.module('App').controller('masters', function($scope) {
    return bindArguments($scope, arguments);
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
      $('body').on('drop dragover', function(e) {
        e.preventDefault();
        return false;
      });
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
              $scope.order.photos.splice(-1);
              $scope.upload_error = response.result.error;
              eventAction('stat-order-error', response.result.error);
            } else {
              $scope.order.photos[$scope.order.photos.length - 1] = response.result;
              eventAction('stat-file-attach', $scope.order.photos.length);
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
        eventAction('stat-order');
        return $('body').animate({
          scrollTop: $('.header').offset().top
        });
      }, function(response) {
        var errors_string;
        $scope.sending = false;
        errors_string = [];
        angular.forEach(response.data, function(errors, field) {
          var input, selector;
          $scope.errors[field] = errors;
          errors_string.push((field + ": ") + errors.join(', '));
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
        return eventAction('stat-order-error', errors_string.join(' | '));
      });
    };
  });

}).call(this);

(function() {
  angular.module('App').controller('other', function($scope) {
    return bindArguments($scope, arguments);
  });

}).call(this);

(function() {
  angular.module('App').controller('price', function($scope) {
    return bindArguments($scope, arguments);
  });

}).call(this);

(function() {
  angular.module('App').constant('REVIEWS_PER_PAGE', 5).controller('reviews', function($scope, $timeout, $http, Subjects, StreamService) {
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
      return $http.get('/api/reviews/bypage?page=' + $scope.page).then(function(response) {
        console.log(response);
        $scope.searching = false;
        $scope.reviews = $scope.reviews.concat(response.data.reviews);
        return $scope.has_more_pages = response.data.has_more_pages;
      });
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
  angular.module('App').directive('galleryItemMain', function() {
    return {
      restrict: 'E',
      scope: {
        item: '=',
        service: '='
      },
      templateUrl: '/directives/gallery-item-main'
    };
  });

}).call(this);

(function() {
  angular.module('App').directive('galleryItem', function() {
    return {
      restrict: 'E',
      scope: {
        item: '=',
        service: '=',
        index: '='
      },
      templateUrl: function(elem, attrs) {
        if (isMobile) {
          return '/directives/gallery-item-mobile';
        } else {
          return '/directives/gallery-item';
        }
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
          var event_name, target, ul;
          if (item.items && item.items.length) {
            target = $(event.target).hasClass('price-line') ? $(event.target) : $(event.target).closest('.price-line');
            target.toggleClass('active');
            ul = target.parent().children('ul');
            event_name = ul.is(':visible') ? prefixEvent('price-minimize') : prefixEvent('price-expand');
            eventAction(event_name, item.model.name);
            return ul.slideToggle(250);
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
    this.displayed = 3;
    el = null;
    scroll_left = null;
    DIRECTION = {
      next: 1,
      prev: 0
    };
    animation_in_progress = false;
    this.initialized = false;
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
      var speed;
      if (animation_speed == null) {
        animation_speed = 500;
      }
      animation_in_progress = true;
      speed = this.initialized ? animation_speed : 100;
      el.stop().animate({
        scrollLeft: this.screen_width * this.active + this.screen_width - (($(window).width() - this.screen_width) / 2)
      }, speed, function() {
        return animation_in_progress = false;
      });
      return this.initialized = true;
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
