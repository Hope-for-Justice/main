<?php 


/*
 * REDIRECT FUNCTION
 * Hooks into give_get_success_page_uri
 * 
 */
 
function pfconfs_4_give_redirects( $success_page ) {

    $form_id = isset( $_POST['give-form-id'] ) && is_numeric( $_POST['give-form-id'] ) ? intval( $_POST['give-form-id'] ) : 0;

    if ( $form_id <= 0 ) { return $success_page; }

    $give_options = give_get_settings();

    $redirect_status = get_post_meta( $form_id, 'pfconfs4givewp-fields_status', true);
    $conf_url = get_post_meta( $form_id, 'pfconfs4givewp-fields_page_url', true);
    $permalink = get_permalink($conf_url);

	if ( $redirect_status == 'customize' ) {
        $success_page = esc_url($permalink);
    } 

	return $success_page;

}

add_filter( 'give_get_success_page_uri', 'pfconfs_4_give_redirects', 10, 1 );

/*
 * MESSAGING FUNCTIONS
 * Adds custom messaging above/below the donation confirmation table
 */
add_action('give_payment_receipt_before_table', 'pfconfs4givewp_output_sharing_above', 11, 2);
add_action('give_payment_receipt_after_table', 'pfconfs4givewp_output_sharing_below', 11, 2 );

function pfconfs4givewp_output_sharing( $donation, $give_receipt_args, $output_position ) {
    
    global $donation, $give_receipt_args;

    $args['ID']     = $donation->ID;
    $args['form_id'] = get_post_meta( $args['ID'], '_give_payment_form_id', true );
    $args['form_meta'] = get_post_meta( $args['form_id'] );

    $position = $args['form_meta']['pfconfs4givewp-fields_message_location'][0];
    $message = $args['form_meta']['pfconfs4givewp-fields_confirmation_message'][0];

    if ( $position === $output_position ) {
        echo wp_kses_post( $message );
    }
}

function pfconfs4givewp_output_sharing_above( $donation, $give_receipt_args ) {
    
    pfconfs4givewp_output_sharing( $donation, $give_receipt_args, 'above' );

}

function pfconfs4givewp_output_sharing_below( $donation, $give_receipt_args ) {

    pfconfs4givewp_output_sharing( $donation, $give_receipt_args, 'below' );

}

function pfconfs_delete_query_transient( $post ) {
    // Deletes the transient when a new post is published
    delete_transient( '_transient_pfconfs_pages_w_shortcode' );
    delete_transient( '_pfconfs_pages_w_shortcode' );
    delete_transient( 'pfconfs_pages_w_shortcode' );
}

add_action( 'transition_post_status', 'pfconfs_delete_query_transient' );