//
// training scripts
//


jQuery(document).ready(function($) {


$(".training-dropdown__trigger").click(function(){

    $(this).find(".training-dropdown__content").slideToggle(350);
    $(this).find(".training-dropdown__cross").toggleClass("training-dropdown__cross--open");
    
    $(".training-dropdown__trigger").not(this)
    .find(".training-dropdown__content").slideUp(350);
    
    $(".training-dropdown__trigger").not(this)
    .find(".training-dropdown__cross").removeClass("training-dropdown__cross--open");

});


});
