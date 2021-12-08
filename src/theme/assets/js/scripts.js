/* Page load scripts */

jQuery(document).ready(function($) {

    //url param function
    var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    // lottie
    var getInvolved;
    var elem = document.getElementById('getInvolved');

        if (elem != undefined) {
        var animData = {
            container: elem,
            renderer: 'canvas',
            loop: false,
            autoplay: false, //change to false when using trigger
            rendererSettings: {
                progressiveLoad:false
            },
            path: '/wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json',
            //on wp-engine /wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json
            //on local setup /build/themes/hope-for-justice-2020/assets/img/getinvolved.json
        };
        getInvolved = bodymovin.loadAnimation(animData);


        //waypoint
        var waypoint = new Waypoint({
        element: document.getElementById('getInvolved'),
          handler: function(direction) {
            getInvolved.play();
          },
          offset: '50%'
        }); 
    }

    // //if donate=true show donate form
    // var donate = getUrlParameter('donate');
    // if(donate == "true") {
    //     //modal (spash)
    //     $('#payment-modal-once').modal('show');
    // } else if(donate == "monthly")   {
    //     //modal (spash)
    //     $('#payment-modal-regular').modal('show');
    // }

    //Drop down questions
    $('.dropdown').click(function() {
        $(this).toggleClass('dropdown--open');
    });

    //Drop cards
    $('.drop-card__header').click(function() {
        $(this).parent().toggleClass('drop-card--open');
        $(this).find('.cross-circle').find('.cross-circle__plus')
        .toggleClass('cross-circle__plus--open');
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
    if ($(window).width() > 767) {
        $("#newsTicker").eocjsNewsticker();
        $(".newsticker").css('opacity','1');
    }
    

    // Burger menu
    let isOpen = false;
    $('#burger-menu').click(function(){
        if (isOpen == false) {
            $(this).find('.burger').toggleClass('open');
            $('#menu').toggleClass('menu--open');
            $(".menu__inner").css("opacity", "1");  
            isOpen = true;
        } else {
            $(this).find('.burger').toggleClass('open');
            $(".menu__inner").css("opacity", "0");
            $('#menu').toggleClass('menu--open');
            isOpen = false;
        }
    });

    // autoplay bootstrap modal video
    var $videoSrc;
    var $frame = $(".video");
    $('.video-trigger').click(function() {
        $videoSrc = $(this).data( "src" );
        console.log($videoSrc);
        $frame.attr('src', $videoSrc + "?autoplay=1");
    });

    $('.modal').on('hidden.bs.modal', function(e) {
        // sets the source to nothing, stopping the video
        $frame.attr('src', '');
    })

    //reference modal text 
    var $text;
    $('.reference__symbol, .reference').click(function() {
        $text = $(this).data( "text" );
        $title = $(this).data("title");
        $(".modal__text").html($text);
        $(".modal__title").html($title);
    });

    //flexslider
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
    $('.text-slider__prev, .text-slider__next').on('click', function(){
        var href = $(this).attr('href');
        $('.flexslider-text').flexslider(href)
        return false;
    })

    // responsive resizing videos
    //$(".page").fitVids();
    //$(".single").fitVids();
    $('iframe[src*="youtube"]').parent().fitVids();
   
   $('.get-help-modal__country-select').find('select').on('change', function(){
        let select = $(this).val();
        let title = $(".get-help-modal__title");
        let text = $(".get-help-modal__text");
        let flag = $(".get-help-modal__country-flag img");
        let number = $(".get-help-modal__number");
        let or = $(".get-help-modal__or");
        let email = $(".get-help-modal__email");
        let name = $(".get-help__name input");
        let message = $(".get-help__message textarea");
        let button = $(".get-help-modal .gform_button");

        if (select == "Spanish") {
            $(title).html("test<br> title");
            $(text).text("test");
            $(flag).attr('src', 'https://hfj2.wpengine.com/wp-content/uploads/2021/12/spn-flag.png');
            $(number).text("10300 008 8000");
            $(or).text("x");
            $(email).text("x@x.com");
            $(name).attr('placeholder', 'test');
            $(message).attr('placeholder','test');
            $(button).val("test");
        }
        if (select == "English") {
            $(title).html("DO YOU<br> NEED HELP?");
            $(text).text("Hope for Justice is not an emergency service. If your life or someone else’s life is in immediate danger, always call 999 first.");
            $(flag).attr('src', 'https://hfj2.wpengine.com/wp-content/uploads/2021/11/eng-flag.png');
            $(number).text("0300 008 8000");
            $(or).text("or");
            $(email).text("help@hopeforjustice.org");
            $(name).attr('placeholder', 'Your Name');
            $(message).attr('placeholder','Your message. \n \nHow and when can we contact you?');
            $(button).val("Submit");
        }

    });

}); /* end of as page load scripts */









//gravity forms on render
jQuery(document).on('gform_post_render', function(event, form_id, current_page){


    // //modify field name to 'search' on gravity forms if class exists
    // jQuery(".address-search input").attr("name","search");

    //show address fields on click
    jQuery(".address-link").on('click', function(){
        jQuery(".address-fields").show();
    });

    //remove html in search input on click
    jQuery(".address-search input").on("click", function(){
        jQuery(this).val("");
    });

    //postcode anywhere with regex matching
    var e = {
        key: "DN97-JG93-ZJ46-EW48" //PCA API key
    },
    d = [{
        element: "search", // use the field named 'search' to search
        field: "",
        mode: pca.fieldMode.SEARCH
    }, {
        element: "^input_[0-9]{1,}_[0-9]{1,}_1$",
        field: "Line1",
        mode: pca.fieldMode.POPULATE
    }, {
        element: "^input_[0-9]{1,}_[0-9]{1,}_2$",
        field: "Line2",
        mode: pca.fieldMode.POPULATE
    }, {
        element: "^input_[0-9]{1,}_[0-9]{1,}_3$",
        field: "City",
        mode: pca.fieldMode.POPULATE
    }, {
        element: "^input_[0-9]{1,}_[0-9]{1,}_4$",
        field: "Province",
        mode: pca.fieldMode.POPULATE
    }, {
        element: "^input_[0-9]{1,}_[0-9]{1,}_5$",
        field: "PostalCode",
        mode: pca.fieldMode.POPULATE
    }],
    o = new pca.Address(d, e);
    o.listen("populate", function() {
        jQuery(".address-search input").val(jQuery(".address_line_1 input").val() + "...");
    }), o.load()

});



/* Window load scripts */
(function($) {

	jQuery(window).on('load', function() {

    // Headroom
    var elem = document.querySelector("header");
    var headroom  = new Headroom(elem, {
          "offset": 150,
          "tolerance": 5,
          "classes": {
            "pinned": "header--slideDown",
            "unpinned": "header--slideUp"
    }
    });
    // initialise
    headroom.init();

    //url param function
    var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    //if no donate url param show splash
    // var donate = getUrlParameter('donate');
    // if(donate != "true" && donate != "monthly") {
    //     $('#splash-modal').modal('show');
    // }

    //give wp
    $("#usaForm, #usaFormMonthly").find('iframe').contents().find(".currency--before").html('$');
    //$("#ausForm").find('iframe').contents().find(".currency--before").html('$');
    $("#norwayForm, #norwayFormMonthly").find('iframe').contents().find(".currency--before").html('Kr.');
    
    //const selectOption = $(".give-embed-form-wrapper").find('iframe').contents().find(".preferencesQuestion").find('select');
    //const options = $(".give-embed-form-wrapper").find('iframe').contents().find(".preference"); 
    //const preferenceText = $(".give-embed-form-wrapper").find('iframe').contents().find(".preferenceText");

    // let selectedValue = selectOption.val();
        
    // function preferenceQuestions(){
    //     let selectedValue = selectOption.val();
    //     if (selectedValue !== "Yes, keep my settings as they are") {
    //         $(options).each(function(i) {
    //             $(this).show();
    //             $(this).find('select').children('option:nth-child(4)').prop('hidden','true');
    //             $(this).find('select').children('option:nth-child(1)').prop('selected','selected');
    //             $(preferenceText).parent().show();
    //         });
    //     } else {
    //         $(options).each(function(i) {
    //             $(this).hide();
    //             $(this).find('select').children('option:nth-child(4)').prop('hidden','true');
    //             $(this).find('select').children('option:nth-child(4)').prop('selected','selected');
    //             $(preferenceText).parent().hide();
    //         });
    //     }  
    // }

    // preferenceQuestions();

    // selectOption.change(function (){
    //     preferenceQuestions();
    // });

    //Homepage
        // if(!$(".modal").length){
        //     $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
        // } 

        // $('.modal').on('hidden.bs.modal', function () {
        //     $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
        // });
        

        //cards
        Draggable.create(".drag-cards__inner", {
            allowNativeTouchScrolling:false,
            type:"x",
            bounds: {maxX:0}, //keeps it left drag only
            onRelease:function() {
                TweenLite.set(this.target, {zIndex:0});
            }
        });


	}); /* end of on widow load*/

})(jQuery);


