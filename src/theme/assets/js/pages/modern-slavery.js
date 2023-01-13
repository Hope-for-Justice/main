/* Page load scripts */
jQuery(document).ready(function ($) {//flexslider

    $('.flexslider-text').flexslider({
        animation: "fade",
        //slideshow: true,
        animationLoop: true,
        directionNav: false,
        controlNav: false,
        video: false,
        pauseOnHover: false,
        slideshowSpeed: 6000,
        animationSpeed: 300,
        //smoothHeight: true,
    });

    //custom next/prev 
    /* will need to be more specific if
    multiple sliders are on one page */
    $('.text-slider__prev, .text-slider__next').on('click', function () {
        var href = $(this).attr('href');
        $('.flexslider-text').flexslider(href)
        return false;
    });

    //cards
    Draggable.create(".drag-cards__inner", {
        allowNativeTouchScrolling: false,
        type: "x",
        bounds: { maxX: 0 }, //keeps it left drag only
        onRelease: function () {
            TweenLite.set(this.target, { zIndex: 0 });
        }
    });

});