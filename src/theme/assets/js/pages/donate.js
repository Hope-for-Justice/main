//
// Donate scripts
//


jQuery(document).ready(function($) {


    var monthly = true; 
    // Campaigns/ Norway starts on one-off
    if ($('#initialDonationType').val() == "once") {
        slider();
    }

    //toggle slider for monthly or single donation change amounts and messages
    $('.toggle__option, .toggle__slider').click(slider);

    function slider() {
        $('.toggle__slider').toggleClass('toggle__slider--left');
        $('.donate__button').toggleClass('donate__button--monthly');
        monthly = !monthly;
        
        if (monthly !== true) {
            $('.donate__form--monthly').hide();
            $('.donate__form--once').show();
            $('.donate__info--monthly').hide();
            $('.donate__info--once').show(); 
            
        } else {
            $('.donate__form--monthly').show();
            $('.donate__form--once').hide();
            $('.donate__info--monthly').show();
            $('.donate__info--once').hide()
            
        }
    }




});


