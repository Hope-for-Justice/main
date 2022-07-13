//
// Church partnerships scripts
//


jQuery(document).ready(function ($) {

    //gsap.set(".gsap-no-height", { height: 0 });

    $(".church-partnerships__see-more").click(function () {
        showMore(this);
        $(this).toggleClass("church-partnerships__see-more--open");
    });

    $("#scrollto").click(function () {
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#scrollToHere").offset().top - 100
        }, 400);
    });

    function showMore(el) {
        let below = $(el).hasClass("church-partnerships__see-more--below");
        if (below) {
            elem = $(el).next("p").find(".gsap-no-height");
        } else {
            elem = $(el).prev("p").find(".gsap-no-height");
        }
        let open = $(el).hasClass("church-partnerships__see-more--open");
        if (!open) {
            gsap.to(elem, { duration: 0.4, height: "auto", ease: Power1.easeOut });
        } else {
            gsap.to(elem, { duration: 0.4, height: 0, ease: Power1.easeOut });
        }
    }


});