<?php
/**
 * Notice
 *
 * Notice related functionality goes in this file.
 *
 * @since   1.0.0
 * @package WP
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'pfconfs_4_givewp_review_notice' ) ) {
    // Add an admin notice.
   add_action('admin_notices', 'pfconfs_4_givewp_review_notice');

    /**
     *  Admin Notice to Encourage a Review or Donation.
     *
     *  @author Matt Cromwell
     *  @version 1.0.0
     */
    function pfconfs_4_givewp_review_notice() {

        // Define your Plugin name, review url, and donation url.
        $plugin_name = __('Per Form Confirmations for GiveWP', 'pfconfs-4-givewp');
        $donate_url = 'https://givewp.com/?utm_source=pfconfs4givewp&utm_medium=wp-admin&utm_campaign=notice-links';

        // Get current user.
        global $current_user, $pagenow ;
        $user_id = $current_user->ID;

        // Get today's timestamp.
        $today = mktime( 0, 0, 0, date('m')  , date('d'), date('Y') );

        // Get the trigger date
        $triggerdate = get_option( 'pfconfs_4_givewp_activation_date', false );

        $installed = ( ! empty( $triggerdate ) ? $triggerdate : '999999999999999' );

        // First check whether today's date is greater than the install date plus the delay
        // Then check whether the user is a Super Admin or Admin on a non-Multisite Network
        // For testing live, remove `$installed <= $today &&` from this conditional
        //if ( pfconfs_4_givewp_is_super_admin_admin( $current_user = $current_user ) == true ) {
        if ( $installed <= $today && pfconfs_4_givewp_is_super_admin_admin( $current_user = $current_user ) == true ) {

            // Make sure we're on the plugins page.
            if ( 'plugins.php' == $pagenow ) {

                // If the user hasn't already dismissed our alert,
                // Output the activation banner.
                $nag_admin_dismiss_url = 'plugins.php?pfconfs_4_givewp_review_dismiss=0';
                $user_meta             = get_user_meta( $user_id, 'pfconfs_4_givewp_review_dismiss' );

                if ( empty($user_meta) ) {

                    ?>
                    <div class="notice notice-success">
                        <?php
                        // For testing purposes
                        //echo '<p>Today = ' . $today . '</p>';
                        //echo '<p>Installed = ' . $installed . '</p>';
                        ?>

                        <p class="pfc4givewp-review">
                            <i class="dashicons dashicons-heart"></i>
                                <?php echo wp_kses( 
                                    sprintf( 
                                        __( 'Are you enjoying <strong>%1$s</strong>? Check out all the ways you can level up your online fundraising with our <a href="%2$s" target="_blank">GiveWP Pricing Plans</a>.', 'pfconfs-4-givewp' ), 
                                        $plugin_name, 
                                        esc_url( $donate_url ) ), 
                                        array( 'strong' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?>
                                        <a href="<?php echo admin_url( $nag_admin_dismiss_url ); ?>" class="dismiss"><i class="dashicons dashicons-dismiss"></i></a>

                    </div>

                <?php }
            }
        }
    }
}


if ( ! function_exists( 'pfconfs_4_givewp_ignore_review_notice' ) ) {
    // Function to force the Review Admin Notice to stay dismissed correctly.
    add_action('admin_init', 'pfconfs_4_givewp_ignore_review_notice');

    /**
     * Ignore review notice.
     *
     * @since  1.0.0
     */
    function pfconfs_4_givewp_ignore_review_notice() {
        if ( isset( $_GET[ 'pfconfs_4_givewp_review_dismiss' ] ) && '0' == $_GET[ 'pfconfs_4_givewp_review_dismiss' ] ) {

            // Get the global user.
            global $current_user;
            $user_id = $current_user->ID;

            add_user_meta( $user_id, 'pfconfs_4_givewp_review_dismiss', 'true', true );
        }
    }
}

if ( ! function_exists( 'danp_is_super_admin_admin' ) ) {

    // Helper function to determine whether the current
    // user is a Super Admin or Admin on a non-Network environment
    function pfconfs_4_givewp_is_super_admin_admin($current_user)
    {
        global $current_user;

        $shownotice = false;

        if (is_multisite() && current_user_can('create_sites')) {
            $shownotice = true;
        } elseif (is_multisite() == false && current_user_can('install_plugins')) {
            $shownotice = true;
        } else {
            $shownotice = false;
        }

        return $shownotice;
    }
}