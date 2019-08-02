var isMobile = true
var isIphone4 = window.screen && (window.screen.height == (960 / 2));

// добавили JS стили (для мобильной галереи)
var css_injected = false;

$(document).ready(function() {
    if (isIphone4) {
        $('body').addClass('iphone4');
    }

	$('.header-menu-button').click(function() {
        openModal('menu')
        // close all expanded menus
        $('#modal-menu').scrollTop(0)
        $('#menu-overlay .price-item-root ul').attr('style', '')
        eventAction('mob-burger-open') 
	})

    $('.equipment-item').last().css({'border-bottom': 'none'})
    
    // bindToggle()

	// if (isMobile && isIphone4) $('body').addClass('iphone4fix');

    $('.questions-item-answer img.can-resize, .questions-item-answer .zoom-hint').click(function() {
        elem = $('#modal-faq-img img');
        elem.attr('src', $(this).attr('src'));
        margin_top = (elem.parent().actual('height') - elem.actual('height')) / 2;
        elem.css({marginTop: margin_top + 'px'});
        elem.panzoom('reset');
        elem.panzoom('destroy');
        console.log('reset');

        (function(target) {
            setTimeout(function() {
                target.panzoom({
                    minScale: 1,
                    maxScale: 3,
                    increment: 1.2,
                    contain: 'automatic',
                    panOnlyWhenZoomed: true,
                    disablePan: true
                });
            }, 500);
        })(elem);

        openModal('faq-img');
    });
})

// function togglePrice(){
//     var $parent = $(this).closest('.price-list-item');

//     $parent.toggleClass('price-list-item__active');
//     $parent.children('.price-list-inner').slideToggle();
// }

function toggleCatalog(){
    var $parent = $(this).parent('.catalog-list-item');

    $parent.toggleClass('catalog-list-item__active');
    $parent.children('.catalog-list-inner').slideToggle();
}

// function bindToggle() {
//     $('.price-list .price-list-item-title').click(togglePrice)
//     $('.catalog-list .catalog-list-item-title').click(toggleCatalog)
// }

//# sourceMappingURL=scripts.js.map