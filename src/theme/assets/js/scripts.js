/* Page load scripts */

jQuery(document).ready(function($) {



    //Drop down questions
    $('.dropdown').click(function() {
        $(this).find(".answer").slideDown();
        $(".dropdown").not(this).find(".answer").slideUp();
    });

    // Bootstrap modal url hashing
    $(".modal").on("shown.bs.modal", function()  { // any time a modal is shown
        $(this).find(".modal__dialog").addClass("animate__animated animate__fadeInDown").fadeIn();
        var urlReplace = "#" + $(this).attr('id'); // make the hash the id of the modal shown
        history.pushState(null, null, urlReplace); // push state that hash into the url
    });

    // If a pushstate has previously happened and the back button is clicked, hide any modals.
    $(window).on('popstate', function() { 
        $(".modal").modal('hide');
     });

    // Burger menu
    $('#burger-menu').click(function(){
        $(this).toggleClass('open');
    });

    //rangeslider
    $('input[type="range"]').rangeslider({
        polyfill:false,
        onInit : function() {
            this.output = $('.rangeslider__handle').html( "£" + this.$element.val() );
            $('#preAmount').val(this.$element.val());
        },
        onSlide : function( position, value ) {
            this.output.html( "£" + value );
            $('#preAmount').val(this.$element.val());
        }
    });


}); /* end of as page load scripts */


/* Window load scripts */
(function($) {

	jQuery(window).on('load', function() {



    //modal (spash)
    $('#splash-modal').delay( 400 ).modal('show');

    //News ticker
    $("#newsTicker").eocjsNewsticker();

    //Homepage

        if(!$(".modal").length){
            $(".hero__content").addClass("animate__animated animate__fadeInDown animate__delay-2s").fadeIn();
        } 

        $('.modal').on('hidden.bs.modal', function () {
            $(".hero__content").addClass("animate__animated animate__fadeInDown").fadeIn();
        });
        
        // giving widget 
        $('#custom-amount').click(function() { 
            $(this).fadeOut(400);
            $('.giving-widget__rangeslider').fadeOut(400);
            $('.giving-widget__feedback').fadeOut(400);
            $('.giving-widget__amount').fadeIn(400);
        });


	}); /* end of as page load scripts */

})(jQuery);


