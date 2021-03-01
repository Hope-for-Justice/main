/* Page load scripts */

jQuery(document).ready(function($) {



    //Drop down questions
    $('.dropdown').click(function() {
        $(this).find(".answer").slideDown();
        $(".dropdown").not(this).find(".answer").slideUp();
    });

    // Bootstrap modal
    $(".modal").on("shown.bs.modal", function()  { // any time a modal is shown
        $(this).find(".modal__content").addClass("animate__animated animate__fadeInDown").fadeIn(); //animate in
        var urlReplace = "#" + $(this).attr('id'); // make the hash the id of the modal shown
        history.pushState(null, null, urlReplace); // push state that hash into the url
    });

    // If a pushstate has previously happened and the back button is clicked, hide any modals.
    $(window).on('popstate', function() { 
        $(".modal").modal('hide');
     });

    //News ticker
    $("#newsTicker").eocjsNewsticker();

    // Burger menu
    let isOpen = false;
    $('#burger-menu').click(function(){
        if (isOpen == false) {
            $(this).toggleClass('open');
            $('#site-header').toggleClass('header--open');
            $('#menu').delay(400).fadeIn(200);
            isOpen = true;
        } else {
            $(this).toggleClass('open');
            $('#menu').fadeOut(200);
            window.setTimeout(function() {
                $('#site-header').toggleClass('header--open');
            }, 300);
            isOpen = false;
        }
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

    // Headroom
    var elem = document.querySelector("header");
    var headroom  = new Headroom(elem, {
          "offset": 205,
          "tolerance": 5,
          "classes": {
            "pinned": "header--slideDown",
            "unpinned": "header--slideUp"
    }
    });
    // initialise
    headroom.init();

    //modal (spash)
    $('#splash-modal').modal('show');



    //Homepage

        if(!$(".modal").length){
            $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
        } 

        $('.modal').on('hidden.bs.modal', function () {
            $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
        });
        
        // giving widget 
        $('#custom-amount').click(function() { 
            $(this).fadeOut(400);
            $('.giving-widget__rangeslider').fadeOut(400);
            $('.giving-widget__feedback').fadeOut(400);
            $('.giving-widget__amount').fadeIn(400);
        });

        // lottie
        var getInvolved;
        var elem = document.getElementById('getInvolved')
        var animData = {
            container: elem,
            renderer: 'svg',
            loop: false,
            autoplay: false,  
            rendererSettings: {
                progressiveLoad:false
            },
            path: '/wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json',
            ///wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json
            ///build/themes/hope-for-justice-2020/assets/img/getinvolved.json
        };
        getInvolved = bodymovin.loadAnimation(animData);

        var waypoint = new Waypoint({
        element: document.getElementById('waypoint'),
          handler: function(direction) {
            getInvolved.play();
          },
          offset: 200
        });

        //cards
        Draggable.create(".cards__inner", {
            bounds:".cards",
            allowNativeTouchScrolling:false,
            type:"x"
        }
        )


	}); /* end of as page load scripts */

})(jQuery);


