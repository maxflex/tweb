var isMobile = true;
var isIphone4 = window.screen && window.screen.height == 960 / 2;

// добавили JS стили (для мобильной галереи)
var css_injected = false;

$(document).ready(function () {
  if (isIphone4) {
    $("body").addClass("iphone4");
  }

  $(".header-menu-button").click(function () {
    openModal("menu");
    // close all expanded menus
    $("#modal-menu").scrollTop(0);
    $("#menu-overlay .price-item-root ul").attr("style", "");
    eventAction("mob-burger-open");
  });

  $(".equipment-item").last().css({ "border-bottom": "none" });

  // bindToggle()

  // if (isMobile && isIphone4) $('body').addClass('iphone4fix');
});

//# sourceMappingURL=scripts.js.map
