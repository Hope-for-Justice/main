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


}); /* end of as page load scripts */


//gravity forms on render

//Address search
jQuery(document).on('gform_post_render', function(event, form_id, current_page){

    //modify field name to 'search' on gravity forms if class exists
    jQuery(".address-search input").attr("name","search");

    //show address fields on click
    jQuery(".address-link").on('click', function(){
        jQuery(".address-fields").show();
    });

    //remove html in search input on click
    jQuery(".address-search input").on("click", function(){
        jQuery(this).val("");
    });

    //global postcode anywhere with regex matching
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
    //alert("yes");
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

    //modal (spash)
    $('#splash-modal').modal('show');

    //Homepage

        // if(!$(".modal").length){
        //     $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
        // } 

        // $('.modal').on('hidden.bs.modal', function () {
        //     $(".hero__content").addClass("animate__animated animate__fadeInDown").css('opacity','1');
        // });
        

        // lottie
        var getInvolved;
        var elem = document.getElementById('getInvolved')
        var animData = {
            container: elem,
            renderer: 'svg',
            loop: false,
            autoplay: true, //change to false when using with scroll trigger gsap 
            rendererSettings: {
                progressiveLoad:false
            },
            path: '/build/themes/hope-for-justice-2020/assets/img/getinvolved.json',
            //on wp-engine /wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json
            //on local setup /build/themes/hope-for-justice-2020/assets/img/getinvolved.json
        };
        getInvolved = bodymovin.loadAnimation(animData);



        // var waypoint = new Waypoint({
        // element: document.getElementById('waypoint'),
        //   handler: function(direction) {
        //     getInvolved.play();
        //   },
        //   offset: 200
        // }); /////////////////// replace with scroll trigger gsap

        //cards
        Draggable.create(".drag-cards__inner", {
            allowNativeTouchScrolling:false,
            type:"x",
            bounds: {maxX:0}, //keeps it left drag only
            onRelease:function() {
                TweenLite.set(this.target, {zIndex:0});
            }
        });

        //flexslider
        $('.flexslider').flexslider({
            animation: "slide",
            slideshow: true,
            animationLoop: true,
            directionNav: false,
            controlNav: false,
            video: false,
            pauseOnHover: false,
            slideshowSpeed: 2000,
            animationSpeed: 600, 
        });


	}); /* end of on widow load*/

})(jQuery);


