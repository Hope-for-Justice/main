/* Page load scripts */

jQuery(document).ready(function($) {

    //Drop down questions
    $('.dropdown').click(function() {
        $(this).find(".answer").slideDown();
        $(".dropdown").not(this).find(".answer").slideUp();
    });

    // Bootstrap modal url hashing
    $(".modal").on("shown.bs.modal", function()  { // any time a modal is shown
        var urlReplace = "#" + $(this).attr('id'); // make the hash the id of the modal shown
        history.pushState(null, null, urlReplace); // push state that hash into the url
    });

    // If a pushstate has previously happened and the back button is clicked, hide any modals.
     $(window).on('popstate', function() { 
        $(".modal").modal('hide');
     });

}); /* end of as page load scripts */


/* Window load scripts */
(function($) {

	jQuery(window).load(function() {

	}); /* end of as page load scripts */

})(jQuery);

