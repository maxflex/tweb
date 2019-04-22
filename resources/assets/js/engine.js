var scope = null
var player = {}
var players = {}
var isMobile = false
var modal_inited = false
var scrollPosition = false

// window.onYouTubeIframeAPIReady = function () { console.log('ready') }

window.onYouTubeIframeAPIReady = function() {
    console.log('onYouTubeIframeAPIReady')
    if (isMobile) {
        initVideosMobile();
     } else {
        initVideosDesktop();
     }
}

$(document).ready(function() {
    //Custom select
    var $cs = $('.custom-select').customSelect();

    $('.questions-item-title').click(function() {
        $(this)
            .parent()
            .children('.questions-item-answer')
            .toggle();
    });

    $(document).on('keyup', function(event) {
        if (event.keyCode == 27) {
            closeModal()
        }
    })

    //
    // close modal on «back» button
    //
    $(window).on('hashchange', function() {
        if(window.location.hash != "#modal") {
            closeModal()
        }
    });

    angular.element(document).ready(function() {
		setTimeout(function() {
			scope = angular.element('[ng-app=App]').scope()
		}, 50)
	})

    // каждый раз, когда открывается любоая страница
    // отправляем стрим landing
    // $.post('/api/stream', {
    //     action: 'page',
    //     href: window.location.href,
    //     google_id: googleClientId(),
    //     yandex_id:
    // })
    // setTimeout(function() {
    //     scope.StreamService.run('page', null, {href: window.location.href})
    // }, 500)
})

function closeModal() {
    $('.modal.active').removeClass('modal-animate-open').addClass('modal-animate-close')
    // if(window.location.hash == "#modal") {
    //     window.history.back()
    // }
    setTimeout(function() {
        $('.modal').removeClass('active')
        $('body').removeClass()
    	// $("body").addClass('open-modal-' + active_modal); active_modal = false
        $('.container').off('touchmove');
        // @todo: почему-то эта строчка ломает повторное воспроизведение видео
        if (typeof(onCloseModal) == 'function') {
            onCloseModal()
        }
    }, isMobile ? 300 : 0)
}

function openModal(id) {
    modal = $(".modal#modal-" + id)
    modal.removeClass('modal-animate-close').addClass('active').addClass('modal-animate-open')
    $('#menu-overlay').height('95%').scrollTop(); // iphone5-safari fix
    $("body").addClass('modal-open open-modal-' + id);
    // active_modal = id
    $('.container').on('touchmove', function(e){e.preventDefault();});
    // window.location.hash = '#modal'
    if (typeof(onOpenModal) == 'function') {
        onOpenModal(id)
    }
}

function openVideo(videoId) {
    if (typeof(window.player) !== 'object' || Object.keys(window.player).length === 0) {
        initVideosDesktop()
    }
    window.scrollPosition = document.querySelector('html').scrollTop
    window.player.loadVideoById(videoId)
    window.player.playVideo()
    openModal('video')
}

function initVideosDesktop() {
    if (!YT.Player) {
        return
    }
  window.player = new YT.Player('youtube-video', {});
  window.player.addEventListener("onStateChange", function(state) {
    if (state.data === YT.PlayerState.PLAYING) {
      return setTimeout(function() {
        return $('.fullscreen-loading-black').css('display', 'none');
      }, 500);
    }
  });

  window.onCloseModal = function() {
    document.querySelector('html').scrollTop = window.scrollPosition;
    return player.stopVideo();
  };
};

function initVideosMobile() {
    if (!YT.Player) {
      return;
    }
    return $('.youtube-video').each(function(i, e) {
      var id, iframe, player, requestFullScreen;
      id = $(e).data('id');
      iframe = document.getElementById("youtube-video-" + id);
      requestFullScreen = iframe.requestFullScreen || iframe.mozRequestFullScreen || iframe.webkitRequestFullScreen;
      player = new YT.Player("youtube-video-" + id, {
        playerVars: {
          rel: 0
        }
      });
      window.players[id] = player;
      window.players[id].addEventListener('onStateChange', function(state) {
        requestFullScreen.bind(iframe)();
        if (state.data === YT.PlayerState.PLAYING) {
          return stopPlaying(state.target.a.id);
        }
      });
      return null;
    });
  };


  function stopPlaying(except_id) {
    return $.each(window.players, function(e, p) {
      if (p.getPlayerState && p.getPlayerState() === 1 && p.a.id !== except_id) {
        return p.stopVideo();
      }
    });
  };

/**
 * Биндит аргументы контроллера ангуляра в $scope
 */
function bindArguments(scope, arguments) {
	function_arguments = getArguments(arguments.callee)

	for (i = 1; i < arguments.length; i++) {
		function_name = function_arguments[i]
		if (function_name[0] === '$') {
			continue
		}
		scope[function_name] = arguments[i]
	}
}
/**
 * Получить аргументы функции в виде строки
 * @link: http://stackoverflow.com/a/9924463/2274406
 */
var STRIP_COMMENTS = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg;
var ARGUMENT_NAMES = /([^\s,]+)/g;
function getArguments(func) {
  var fnStr = func.toString().replace(STRIP_COMMENTS, '');
  var result = fnStr.slice(fnStr.indexOf('(')+1, fnStr.indexOf(')')).match(ARGUMENT_NAMES);
  if(result === null)
     result = [];
  return result;
}

function googleClientId() {
    return null;
    //return ga.getAll()[0].get('clientId')
}

window.notify_options = {
    hideAnimation: 'fadeOut',
    showDuration: 0,
    hideDuration: 400,
    autoHideDelay: 3000
}

function dataLayerPush(object) {
    window.dataLayer = window.dataLayer || []
    window.dataLayer.push(object)
}

function keyCount (object) {
    return _.keys(object).length;
}

function streamLink(url, action, type, additional) {
    if (url === null) {
        scope.StreamService.run(action, type, additional)
        return
    }
    if (additional === undefined) {
        additional = {}
    }
    // в tel: тоже не подставлять
    if (url[0] != '/' && url.indexOf('tel') === -1 && url.indexOf('http') === -1) {
        url = '/' + url
    }

    if (url.indexOf('http') === -1 && url.indexOf('tel') === -1) {
        scope.StreamService.run(action, type, additional).then(function(data) {
            window.location = url
        })
    } else {
        scope.StreamService.run(action, type, additional)
        if (url.indexOf('tel') === -1) {
            window.open(url, '_blank')
        } else {
            window.location = url
        }
    }
}

function eventAction(category, action) {
  eventUrl(null, category, action)
}

function prefixEvent(eventName) {
  return isMobile ? 'mob-' + eventName : 'stat-' + eventName
}

function eventUrl(url, category, action) {
  params = {
    event: 'user-event',
    eventCategory: category,
    eventAction: action || null,
  }
  dataLayerPush(params)
  // return
  if (url !== null) {
    special_links = ['whatsapp', 'viber', 'maps', 'yandexnavi', 'tel']
    is_special_link = false
    special_links.forEach(function(link) {
      if (url.indexOf(link) === 0) {
        is_special_link = true
      }
    })

    if (is_special_link) {
      window.location = url
    } else {
      window.location = '/' + url
    }
  }
}

function openChat() {
    $('#intergramRoot > div > div').first().click()
}

function numberWithSpaces(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

function pluralize(number, titles) {
    cases = [2, 0, 1, 1, 1, 2];
    return number + ' ' + titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}

function addStyleString(str) {
    var node = document.createElement('style');
    node.innerHTML = str;
    document.body.appendChild(node);
}

function fileChange(event) {
    if (event.target.files[0].size > 5242880) {
        return false
    }
    setTimeout(function() {
        $('.uploaded-photo-box').last().css('background-image', "url('" + URL.createObjectURL(event.target.files[0]) + "')")
    }, 100)
}


function togglePrice(event, scroll) {
    // console.log('togglePrice', event)
    // scrollTo = $(event.target).offset().top - 66
    target = $(event.target).hasClass('price-line') ? $(event.target) : $(event.target).closest('.price-line')
    target.toggleClass('active')
    ul = target.parent().children('ul')
    if (scroll === true && !ul.is(':visible')) {
        event.target.scrollIntoView({ behavior: 'smooth', block: 'center' })
        // $('#modal-menu').animate({
        //     scrollTop: scrollTo
        // }, 250)
    }
    ul.slideToggle(250)
}

/**
 * Печать дива.
 *
 */
function printDiv(id_div) {
    var contents = document.getElementById(id_div).innerHTML;
    var frame1 = document.createElement('iframe');
    frame1.name = "frame1";
    frame1.style.position = "absolute";
    frame1.style.top = "-1000000px";

    document.body.appendChild(frame1);
    var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
    frameDoc.document.open();
    frameDoc.document.write('<html><head><title>Ателье «Талисман»</title>');
    frameDoc.document.write("<style type='text/css'>\
    	h4 {text-align: center}\
    	p {text-indent: 50px; margin: 0}\
	  </style>"
	);
    frameDoc.document.write('</head><body>');
    frameDoc.document.write(contents);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
    }, 500);
    return false;
}
