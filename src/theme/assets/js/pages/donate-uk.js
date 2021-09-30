//
// Donate scripts
//

let monthly = true;
let customAmount = false;
let donateAmount = jQuery('.donate__button--active').data('valuemonthly');
let donateMessage = jQuery('.donate__button--active').data('monthlymsg');
let donateOccurrence = "monthly";

jQuery(document).ready(function($) {
    
    if (sessionStorage.getItem('widget') !== null && window.location.hash == '') {
        //alert("state set");
        let state = sessionStorage.getItem('widget');
        $('#donateWidget').replaceWith(JSON.parse(state));
        $('#donateWidget').show();
    } 

    if(window.location.hash != '') {
        $('.donate__widget').hide();
        $('.donate__widget-footer').hide();
        $('.form__text--first').hide();
        $('.donate__form').show();
    } else {
        $('.donate__widget').show();
        $('.donate__widget-footer').show();
        $('.form__text--first').show();
        $('.donate__form').hide();
    }


    //set data value to match text
    $('[data-valuemonthly]').each(function(i) {
        $(this).text($(this).data("valuemonthly"));
    });

    $('.donate__message-text').text(donateMessage);
    $('.donate__message-amount').text(donateAmount);

    //toggle slider for monthly or single donation change amounts and messages
    $('.toggle__option, .toggle__slider').click(function() {
        $('.toggle__slider').toggleClass('toggle__slider--left');
        $('.donate__button').toggleClass('donate__button--monthly');
        monthly = !monthly;
        
        if (monthly === true && customAmount === false){
            
            donateMessage = $('.donate__button--active').data('monthlymsg');
            donateAmount = $('.donate__button--active').data('valuemonthly');
            
            $('[data-valuemonthly]').each(function(i) {
                $(this).text($(this).data("valuemonthly"));
            });
        } else if (monthly === true && customAmount === true){
            donateMessage = $('.donate__custom').data('monthlymsg');
            donateAmount = 'custom';
            
            $('[data-valuemonthly]').each(function(i) {
                $(this).text($(this).data("valuemonthly"));
            });
        } else if (monthly === false && customAmount === false) {
            donateMessage = $('.donate__button--active').data('singlemsg');
            donateAmount = $('.donate__button--active').data('valuesingle');
            
            $('[data-valuemonthly]').each(function(i) {
                $(this).text($(this).data("valuesingle"));
            });
        } else {
            donateMessage = $('.donate__custom').data('singlemsg');
            donateAmount = 'custom';
            
            $('[data-valuemonthly]').each(function(i) {
                $(this).text($(this).data("valuesingle"));
            });

        }

        if (monthly === true) {
            $('.occurrence').find('select').val('Monthly').change();
            donateOccurrence = "monthly";
        } else {
            $('.occurrence').find('select').val('Single').change();
            donateOccurrence = "once";
        }

        if (donateAmount !== 'custom'){
            $('.ginput_amount').val(donateAmount);
        } else {
            donateAmount = $('.ginput_amount').val();
        }

        $('.donate__message-text').text(donateMessage);
        $('.donate__message-amount').text(donateAmount);
        $('.donate__amount-preview-occurrence').html(donateOccurrence);
        $('.donate__amount-preview-number').html(donateAmount);
    });

    //function for clicking different prices
    $('.donate__button').click(function() {
        customAmount = false;
        $('.donate__button--active').toggleClass('donate__button--active');
        $(this).toggleClass('donate__button--active');
        $('.donate__custom').removeClass('donate__custom--active');
        
        

        if (monthly === true){
            donateAmount = $(this).data('valuemonthly');
            donateMessage = $(this).data('monthlymsg');
        } else {
            donateMessage = $(this).data('singlemsg');
            donateAmount = $(this).data('valuesingle');
        }

        $('.donate__message-amount').show().text(donateAmount);
        $('.donate__message-text').text(donateMessage);
        
        //set value on gravity form
        $('.ginput_amount').val(donateAmount);
        $('.donate__amount-preview-number').html(donateAmount);
        //alert(donateAmount);
    });

    //function for clicking custom amount
    $('.donate__custom').click(function() {
        customAmount = true;
        $('.donate__button--active').toggleClass('donate__button--active');
        $(this).addClass('donate__custom--active');
        $(this).find('input').focus();

        if (monthly === true){
            donateMessage = $(this).data('monthlymsg');
        } else {
            donateMessage = $(this).data('singlemsg');
        }

        $('.donate__message-amount').hide();
        $('.donate__message-text').text(donateMessage);
        //donateAmount = "custom";

        var value = $('#customAmount').val();
        $('.ginput_amount').val(value);
        donateAmount = value;
        $('.donate__amount-preview-number').html(donateAmount);
        //alert(donateAmount);
    });

    //when custom amount text changes copy it to gravity form
    $('#customAmount').on('input', function() {
        var value = $(this).val();
        $('.ginput_amount').val(value);
        donateAmount = value;
        $('.donate__amount-preview-number').html(donateAmount);
    });

    //when widget next button is pressed show gravity form
    $('#donateNext').click(function() {
        $('.donate__widget').hide();
        $('.donate__widget-footer').hide();
        $('.form__text--first').hide();
        $('.donate__form').show();
        $(window).scrollTop(0);
        $('.dots__dot--active').removeClass('dots__dot--active');
        $('.dots__dot:nth-of-type(2)').addClass('dots__dot--active');
        $('.dots').show();
        let widgetState = $('#donateWidget')[0].outerHTML;
        sessionStorage.setItem('widget', JSON.stringify(widgetState));
        window.location.hash = 'gf1' //add hash to url 
    });

    window.onhashchange = function() {
        if(window.location.hash != '') {
            $('.donate__widget').hide();
            $('.donate__widget-footer').hide();
            $('.form__text--first').hide();
            $('.donate__form').show();
        } else {
            $('.donate__widget').show();
            $('.donate__widget-footer').show();
            $('.form__text--first').show();
            $('.donate__form').hide();
        }
    }

});


//on gravity forms next/prev page rendered

jQuery(document).on('gform_page_loaded', function(event, form_id, current_page){

    //change the active dot 
    if (current_page == 1) {

        jQuery('.dots__dot--active').removeClass('dots__dot--active');
        jQuery('.dots__dot:nth-of-type(2)').addClass('dots__dot--active');

    }else if (current_page == 2) {

        jQuery('.dots__dot--active').removeClass('dots__dot--active');
        jQuery('.dots__dot:nth-of-type(3)').addClass('dots__dot--active');

    } else if (current_page == 3) {

        jQuery('.dots__dot--active').removeClass('dots__dot--active');
        jQuery('.dots__dot:nth-of-type(4)').addClass('dots__dot--active');

    }  

});


//on gravity forms rendered - includes initial load even though form is hidden initially

jQuery(document).on('gform_post_render', function(event, form_id, current_page){

    //default amount
    jQuery('.ginput_amount').val(donateAmount);
    jQuery('.donate__amount-preview-number').html(donateAmount);
    jQuery('.donate__amount-preview-occurrence').html(donateOccurrence);

    jQuery('.donate__amount-preview').click(function() {
        jQuery('.donate__widget').show();
        jQuery('.donate__widget-footer').show();
        jQuery('.donate__form').hide();
        jQuery(window).scrollTop(0);
        jQuery('.form__text--first').show();
        jQuery('.dots').hide();
    });

    //modify ID of firstname to stop conflict with postcode anywhere address regex
    // could remove this if we dont use a complex field on gravity forms
    jQuery("#input_70_54_3").attr("id","firstName");


    //gravity form page specific scripts
    if (current_page == 1) {

        //add a previous button to the first page of the form
        //the user's 'first page' by default isn't part of gravity forms  
        var prevButton = "<a id=\"donatePrev\" class=\"button button--red\"><div class=\"button__inner\"><div class=\"button__text bold\">Previous</div></div></a>"
        jQuery('.gform_page_footer').prepend(prevButton);

        jQuery('#donatePrev').on('click', function(){
            jQuery('.donate__widget').show();
            jQuery('.donate__widget-footer').show();
            jQuery('.donate__form').hide();
            jQuery('.form__text--first').show();
            jQuery(window).scrollTop(0);
            jQuery('.dots__dot--active').removeClass('dots__dot--active');
            jQuery('.dots__dot:nth-of-type(1)').addClass('dots__dot--active');
        });



    } else if (current_page > 1) {

        jQuery('#donatePrev').hide();

    }

    //this code lets us figure out the most appropriate start date for a Donorfy RPI
    //add day of the month to field
    var d = new Date();
    var n = d.getDate()
    jQuery(".day-of-the-month input").val(n);
    
    /* Gravity Forms compare selected day of the month to
    current and output a new date */
    jQuery('.selected-payment-date select').on('change', function() {
        var date = new Date();
        var currentDate = parseInt(jQuery(".day-of-the-month input").val());
        var selectedDate = parseInt(jQuery(".selected-payment-date select").val());
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        var nextYear = date.getFullYear() + 1;
        var nextMonth = date.getMonth() + 2;

        if (currentDate > selectedDate && nextMonth < 13) {
            jQuery(".amended-date input").val(nextMonth + "/" + selectedDate + "/" + year);
        } else if (currentDate > selectedDate && nextMonth > 12) {
            jQuery(".amended-date input").val("01" + "/" + selectedDate + "/" + nextYear);
        } else {
            jQuery(".amended-date input").val(month + "/" + selectedDate + "/" + year);
        }
    });



});