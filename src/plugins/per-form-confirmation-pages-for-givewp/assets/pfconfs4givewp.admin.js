jQuery(document).ready(function($) {
    var price_option = $( '.pfconfs4givewp-fields_status_field input:radio' );
    var message_location = $('.pfconfs4givewp-fields_message_location_field');
    var template = $('input#_give_form_template');

    var fieldset_enable = $('.pfconfs4givewp-fields_status_field');
    var fieldset_page = $('.pfconfs4givewp-fields_page_url_field');
    var fieldset_message_location = $('.pfconfs4givewp-fields_message_location_field');
    var fieldset_message = $('.pfconfs4givewp-fields_confirmation_message_field');

    price_option.on( 'change', function() {

        var price_option_val = $( '.pfconfs4givewp-fields_status_field input:radio:checked' ).val();
        if ( price_option_val === 'customize' ) {
            //set price shows
            $( '.pfconfs4givewp-fields_page_url_field' ).show();
            $( '.pfconfs4givewp-fields_message_location_field' ).show(); // Hide multi-val stuffs.
            $( '.pfconfs4givewp-fields_confirmation_message_field' ).show(); // Hide display style setting.

        } else {
            //multi-value shows
            $( '.pfconfs4givewp-fields_page_url_field' ).hide();
            $( '.pfconfs4givewp-fields_message_location_field' ).hide(); // Hide multi-val stuffs.
            $( '.pfconfs4givewp-fields_confirmation_message_field' ).hide(); // Hide display style setting.
        }
    } ).change();

    message_location.on( 'change', function() {

        var price_option_val = $( '.pfconfs4givewp-fields_message_location_field input:radio:checked' ).val();
        
        if ( price_option_val === 'disabled' ) {
            //set price shows
            $( '.pfconfs4givewp-fields_confirmation_message_field' ).hide();

        } else {
            //multi-value shows
            $( '.pfconfs4givewp-fields_confirmation_message_field' ).show();
        }
    } ).change();

    $('.pfconfs-disabled').hide();

    if ( template.val() == 'legacy') {
        $('.pfconfs-disabled').hide();
        $(fieldset_enable.add(fieldset_page).add(fieldset_message_location).add(fieldset_message).show());
    } 
    if ( template.val() != 'legacy') {
        $('.pfconfs-disabled').show();
        $(fieldset_enable.add(fieldset_page).add(fieldset_message_location).add(fieldset_message).hide());
    }  

    $( '#form_template_options' ).on( 'click', '.js-template--activate', function( ev ) {
        //ev.preventDefault();
        if ( template.val() != 'legacy') {
            $('.pfconfs-disabled').show();
            $(fieldset_enable.add(fieldset_page).add(fieldset_message_location).add(fieldset_message).hide());
        }
        if ( template.val() == 'legacy') {
            $('.pfconfs-disabled').hide();
            $(fieldset_enable.add(fieldset_page).add(fieldset_message_location).add(fieldset_message).show());
        }
    });
});