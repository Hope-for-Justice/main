<?php
/**
 * Hope for Justice 2021 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hope_for_Justice_2021
 */

if ( ! function_exists( 'hope_for_justice_2021_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hope_for_justice_2021_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Hope for Justice 2020, use a find and replace
		 * to change 'hope-for-justice-2020' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'hope-for-justice-2021', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'uk-primary' => esc_html__( 'uk-primary', 'hope-for-justice-2021' ),
			'uk-secondary' => esc_html__( 'uk-secondary', 'hope-for-justice-2021' ),
      'uk-footer-a' => esc_html__( 'uk-footer-a', 'hope-for-justice-2021' ),
      'uk-footer-b' => esc_html__( 'uk-footer-b', 'hope-for-justice-2021' ),
      'uk-footer-c' => esc_html__( 'uk-footer-c', 'hope-for-justice-2021' ),
      'uk-footer-d' => esc_html__( 'uk-footer-d', 'hope-for-justice-2021' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'hope_for_justice_2021_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'hope_for_justice_2021_setup' );

/**
 * Enqueue scripts and styles.
 */
function hope_for_justice_2021_scripts() {
	global $wp_styles;

	wp_enqueue_style( 'hope-for-justice-2021-style', get_stylesheet_uri(), array(), '202110' );

	wp_enqueue_script('jquery'); 
	// wp_enqueue_script( 'justice-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.modal.js', array(), '202110', true );


    wp_enqueue_script( 'hopeforjustice-2021-footer', get_template_directory_uri() . '/assets/js/footer.js', array(), '202110', true );

}

/**
 * Remove admin bumb*/
add_action('get_header', 'my_filter_head');
function my_filter_head() {
remove_action('wp_head', '_admin_bar_bump_cb');
}


add_action( 'wp_enqueue_scripts', 'hope_for_justice_2021_scripts', 1 );

/**
 * Enqueue page specific scripts in a centrally maintained location
 */
function page_scripts() {
    global $post;

    wp_register_script( 'donate', get_template_directory_uri() . '/assets/js/pages/donate.js', array('jquery'), '202110', true);

    $themeVars = array( 'template_directory_uri' => get_template_directory_uri() );

    	//donate uk
      if (is_page('donate') || is_page_template('templates/page-basic-campaign.php')) {
       	wp_enqueue_script('donate');
      }


}

add_action('wp_enqueue_scripts', 'page_scripts',1);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Gravity Wiz // Gravity Forms Unrequire Required Fields for Testing
 *
 * When bugs pop up on your forms, it can be really annoying to have to fill out all the required fields for every test
 * submission. This snippet saves you that hassle by unrequiring all required fields so you don't have to fill them out.
 *
 * @version	  1.0
 * @author    David Smith <david@gravitywiz.com>
 * @license   GPL-2.0+
 * @link      http://gravitywiz.com/speed-up-gravity-forms-testing-unrequire-required-fields/
 * @copyright 2013 Gravity Wiz
 *
 * @wordpress-plugin
 * Plugin Name:       Gravity Forms Unrequire
 * Plugin URI:        http://gravitywiz.com/speed-up-gravity-forms-testing-unrequire-required-fields/
 * Description:       When bugs pop up on your forms, it can be really annoying to have to fill out all the required fields for every test submission. This snippet saves you that hassle by unrequiring all required fields so you don't have to fill them out.
 * Version:           1.0
 * Author:            Gravity Wiz
 * Author URI:        http://gravitywiz.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gwu
 */

class GWUnrequire {
    
    var $_args = null;
    
    public function __construct( $args = array() ) {
        
        $this->_args = wp_parse_args( $args, array(
            'admins_only' => true,
            'require_query_param' => true
        ) );
        
        add_filter( 'gform_pre_validation', array( $this, 'unrequire_fields' ) );
        
    }
    
    function unrequire_fields( $form ) {

        // if( $this->_args['admins_only'] && ! current_user_can( 'activate_plugins' ) )
        //     return $form;

        if( $this->_args['require_query_param'] && ! isset( $_GET['gwunrequire'] ) )
            return $form;
        
        foreach( $form['fields'] as &$field ) {
            $field['isRequired'] = false;
        }
        
        return $form;
    }
        
}

# Basic Usage
#   requires that the user be logged in as an administrator and that a 'gwunrequire' parameter be added to the query string
#   http://youurl.com/your-form-page/?gwunrequire=1

new GWUnrequire();

/**
 * Remove stripe error rate limit on Gravity Forms
 */
add_filter( 'gform_stripe_enable_rate_limits', '__return_false' );


function news_page_scripts() {
	global $wp_styles;
	if (is_page_template('category-news-template.php') || is_page_template('all-categories.php') || is_category('blogs_and_opinion_editorials') || is_category('top_news') || is_category('videos') || is_single() || is_category('in_the_headlines') || is_page('search-news-results') || is_page('careers') || is_page('governance-policies-funding') || is_page('resources-template') || is_page('volunteering-opportunities') || is_page('events') || is_singular('events') || is_page('stories-and-case-studies') || is_singular('stories-and-case-studies')){
		// style files
		//wp_deregister_script('justice-bootstrap');
		if(is_page('volunteering-opportunities') || is_page('events') || is_singular('events')) {
			
		}
		
		
		
	
		wp_enqueue_style( 'news-page-css', get_template_directory_uri() . '/assets/css/news-page.css' );
		wp_enqueue_style( 'gov-pol-fund-css', get_template_directory_uri() . '/assets/css/gov-pol-fund.css' );
		wp_enqueue_style( 'resources-template-css', get_template_directory_uri() . '/assets/css/resources-template.css' );
		wp_enqueue_style( 'volunteering-opportunities-css', get_template_directory_uri() . '/assets/css/volunteering-opportunities.css' );
		wp_enqueue_style( 'events-css', get_template_directory_uri() . '/assets/css/events.css' );
        wp_enqueue_style( 'case-studies-css', get_template_directory_uri() . '/assets/css/case-studies.css' );
		// js files
		// wp_enqueue_script( 'popper-js', get_template_directory_uri() . '/assets/js/popper.min.js', ['jquery-core'] );
		// wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', ['jquery-core'] );
		
		wp_enqueue_script( 'news-page-js', get_template_directory_uri() . '/assets/js/news-page.js', ['jquery-core'] );
		wp_localize_script('news-page-js', 'ajax_object', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		) );
	}
}

add_action( 'wp_enqueue_scripts', 'news_page_scripts', 1 );




function custom_excerpt_length( $length ) {
    return 14;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// add_action( 'wp_ajax_nopriv_ajax_news_video',  'ajax_news_video' );
// add_action( 'wp_ajax_ajax_news_video','ajax_news_video' );
// function ajax_news_video() {
// 	$src = $_POST['src'];
// 	$iframe = '<iframe class="video" src="'.$src.'?autoplay=1"  width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
	
// 	echo $iframe;
//     exit();
// }
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_60bf926dc01e0',
		'title' => 'News Post',
		'fields' => array(
			array(
				'key' => 'field_60bf928245fd0',
				'label' => 'Enter Vimeo Link',
				'name' => 'upload_video',
				'type' => 'oembed',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'width' => '',
				'height' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_category',
					'operator' => '==',
					'value' => 'category:videos',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));

endif;



function process_news_form() {
	// die(print_r($_POST));
    if(isset($_POST['action']) && $_POST['action'] == 'news_search' && wp_verify_nonce($_POST['news_nonce'], 'news-search-nonce')) {
    	$redirect = add_query_arg(array('search' => $_POST['search-posts'],'category' => $_POST['category']), $_POST['redirect'] );
    	wp_redirect($redirect); exit;
       
    }
}
add_action( 'init', 'process_news_form' );


function title_filter($where, $wp_query) {

    global $wpdb;

    if ($search_term = $wp_query->get('search_news_title')) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search_term)) . '%\'';
    }
    return $where;
}
add_filter( 'single_template', function ( $single_template ) {

    $parent     = '6'; //Change to your category ID
    $categories = get_categories( 'child_of=' . $parent );
    $cat_names  = wp_list_pluck( $categories, 'name' );

    if ( has_category( 'videos' )) {
        $single_template = dirname( __FILE__ ) . '/single-videos.php';
    }
    return $single_template;
     
}, PHP_INT_MAX, 2 );


/**
 * Gravity Forms scroll top
 */
add_filter( 'gform_confirmation_anchor', function() {
    return 0;
} );

/**
 * better excerpt ending
 */
function new_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

function gpf_create_post_type() {

  register_post_type( 'gov_pol_fund',
    array(
      'labels' => array(
        'name' => __( 'GPF Modules' ),
        'singular_name' => __( 'GPF Module' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'gov_pol_fund'),
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-text-page',
      'supports' => array( 'thumbnail','title','editor' )

    )
  );
  register_post_type( 'resources_template',
    array(
      'labels' => array(
        'name' => __( 'Resources ' ),
        'singular_name' => __( 'Resources ' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'resources'),
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-media-text',
      'supports' => array( 'thumbnail','title','editor' )

    )
  );
  register_post_type( 'vol_opp',
    array(
      'labels' => array(
        'name' => __( 'Volunteering Opportunities ' ),
        'singular_name' => __( 'Volunteering Opportunity ' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'vol_opp'),
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-media-document',
      'supports' => array('title')

    )
  );
  // register_post_type( 'events',
  //   array(
  //     'labels' => array(
  //       'name' => __( 'Events' ),
  //       'singular_name' => __( 'Event' )
  //     ),
  //     'public' => true,
  //     'has_archive' => true,
  //     'rewrite' => array('slug' => 'event'),
  //     'show_in_rest' => true,
  //     'menu_icon' => 'dashicons-groups',
  //     'supports' => array('thumbnail','title','editor')

  //   )
  // );
  register_post_type( 'stories_case_studies',
    array(
      'labels' => array(
        'name' => __( 'Stories and Case Studies' ),
        'singular_name' => __( 'Story and Case Study' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'stories_case_studies'),
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-clipboard',
      'supports' => array('thumbnail','title','editor')

    )
  );
}
add_action( 'init', 'gpf_create_post_type' );

function add_custom_taxonomies() {



  register_taxonomy('categories', 'gov_pol_fund', array(



    'hierarchical' => true,


    'labels' => array(

      'name' => _x( 'Categories', 'taxonomy general name' ),

      'singular_name' => _x( 'Category', 'taxonomy singular name' ),

      'search_items' =>  __( 'Search Category' ),

      'all_items' => __( 'All Categories' ),

      'parent_item' => __( 'Parent' ),

      'parent_item_colon' => __( 'Parent:' ),

      'edit_item' => __( 'Edit Category' ),

      'update_item' => __( 'Update Category' ),

      'add_new_item' => __( 'Add New Category' ),

      'new_item_name' => __( 'New Category' ),

      'menu_name' => __( 'Category' ),

    ),

    'show_in_nav_menus' => false,

    // Control the slugs used for this taxonomy

    'rewrite' => array(

    'slug' => 'gpf_category', // This controls the base slug that will display before each term

    'with_front' => false, // Don't display the category base before "/locations/"

    'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

    ),

  ));

}

add_action( 'init', 'add_custom_taxonomies', 0 );


// function update_featured_events() {

//   global $posts;
//   global $post;
  
//   // Get other post marked as featured
//   $posts = get_posts([
//   // Array of posts to check  
//   'post_type' => ['events'],
//   'meta_key' => 'pin_event',
//   'meta_value' => 1,
//   'post__not_in' => [$post->ID]
//   ]);

//   // Remove previous featured posts
//   if ( get_field( 'pin_event' ) ) {
//   	foreach( $posts as $p ) {

//   		update_field('pin_event', 0, $p->ID);
//     }
//   } return;

// }
// add_action('acf/save_post', 'update_featured_events', 20);


/**
 *  The multi-step form template and the donor dashboard load in an iframe, which prevents theme styles from interfering with their styles.
 *  To style them, use this PHP snippet to add a custom stylesheet that styles the form or the donor dashboard.
 *  
 *  Make sure you create the givewp-iframes-styles.css file with the CSS styles you'll use.
 */


function my_custom_override_iframe_template_styles() {
    wp_enqueue_style(
        'givewp-iframes-styles',
        get_template_directory_uri() . '/givewp-iframes-styles.css',
        /**
         *  Below, use give-sequoia-template-css to style the multi-step donation form
         *  or use give-donor-dashboards-app to style the donor dashboard
         */
        'give-sequoia-template-css'
    );
}

add_action('wp_print_styles', 'my_custom_override_iframe_template_styles', 10);

//acf issue updating fix
add_filter( 'https_ssl_verify', '__return_false' );

if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page();
  
}

//shortcodes
include('custom-shortcodes.php');
add_shortcode('dropdown', 'dropdown_function');


/**
 * AUTO-POPULATE AMOUNT, NAME, and EMAIL FROM URL STRING
 *
 * This jQuery snippet will auto-populate the Give form amount,
 * first and last name, and email address from a URL you provide
 * EXAMPLE: https://example.com/donations/give-form/?amount=46.00&first=Peter&last=Joseph&email=testing@givewp.com
 *
 * Hooking into the single form view.
 *
 * CAVEATS:
 * -- Your form must support custom amounts
 * -- This snippet only supports one form per page as-is
 */
function my_custom_give_populate_amount_name_email() {
    ?>
    <script>
        ( function( window, document, $, undefined ) {
            'use strict';
    var giveCustom = {};

    giveCustom.init = function() {

        // Are we passed a form ID?
        var form_id = giveCustom.getQueryVariable( 'form_id' ) !== false ? decodeURI( giveCustom.getQueryVariable( 'form_id' ) ) : '';

        if ( form_id !== '' ) {
            // Make to jQuery object.
            var giveForm = $( '.give-form' + giveCustom.getQueryVariable( 'form_id' ) )
        } else {
            // Fallback.
            giveForm = $( '.give-form' );
        }

        // Get the amount from the URL
        var amount = giveCustom.getQueryVariable( 'amount' ) !== false ? decodeURI( giveCustom.getQueryVariable( 'amount' ) ) : '';

        // Update the amount
        var formattedAmount = Give.fn.formatCurrency( amount, {
            symbol: Give.form.fn.getInfo( 'currency_symbol', giveForm ),
            position: Give.form.fn.getInfo( 'currency_position', giveForm )
        }, giveForm );

        // Unformatted amount (for data).
        var unformattedAmount = Give.fn.unFormatCurrency( amount, Give.form.fn.getInfo( 'decimal_separator', giveForm ) );

        // Update the total amount.
        if ( amount ) {
            giveForm.find( '.give-final-total-amount' ).attr( 'data-total', unformattedAmount )
                .text( formattedAmount );
            giveForm.find( '.give-amount-top' ).val(unformattedAmount);
        }

        // Fill personal info fields.

        var firstNamePassedVal = giveCustom.getQueryVariable( 'first' ) !== false ? decodeURIComponent( giveCustom.getQueryVariable( 'first' ) ) : '';
        var lastNamePassedVal = giveCustom.getQueryVariable( 'last' ) !== false ? decodeURIComponent( giveCustom.getQueryVariable( 'last' ) ) : '';
        var emailPassedVal = giveCustom.getQueryVariable( 'email' ) !== false ? decodeURIComponent( giveCustom.getQueryVariable( 'email' ) ) : '';
        var postcodePassedVal = giveCustom.getQueryVariable( 'postcode' ) !== false ? decodeURIComponent( giveCustom.getQueryVariable( 'postcode' ) ) : '';

        var firstNameInput = giveForm.find( '#give-first-name-wrap input.give-input' );
        var lastNameInput = giveForm.find( '#give-last-name-wrap input.give-input' );
        var emailInput = giveForm.find( '#give-email-wrap input.give-input' );
        var postcodeInput = giveForm.find( "#give-post_code-334-9" );

        if ( firstNamePassedVal !== false && firstNameInput.length > 0 ) {
            firstNameInput.val( firstNamePassedVal );
        }
        if ( lastNamePassedVal !== false && lastNameInput.length > 0 ) {
            lastNameInput.val( lastNamePassedVal );
        }
        if ( emailPassedVal !== false && emailInput.length > 0 ) {
            emailInput.val( emailPassedVal );
        }
        if ( postcodePassedVal !== false && postcodeInput.length > 0 ) {
            postcodeInput.val( postcodePassedVal );
        }
    };

    /**
     * Get Query Variable from URL.
     *
     * @param variable
     * @returns {string|boolean}
     */
    giveCustom.getQueryVariable = function( variable ) {
        var query = window.location.search.substring( 1 );
        var vars = query.split( '&' );
        for ( var i = 0; i < vars.length; i ++ ) {
            var pair = vars[ i ].split( '=' );
            if ( pair[ 0 ] == variable ) {
                return pair[ 1 ];
            }
        }
        return false;
    };

    giveCustom.init();

        } )( window, document, jQuery );
    </script>
    <?php
}

add_action( 'give_post_form_output', 'my_custom_give_populate_amount_name_email' );

/**
 * A local translation snippet for making text changes to only one of the forms.
 * Change 'YOUR TEXT HERE' to your desired text, and the "964" to the form ID you'd like to modify.
 *
 * Also, ensure that all functions here have unique names to avoid conflicts.
 *
 * @param $translations
 * @param $text
 * @param $domain
 *
 * @return mixed|string
 */
function my_give_picky_text_switcher( $translations, $text, $domain ) {

    // Only for the 'give' text domain.
    if ( $domain == 'give' && $text == 'First Name' ) {
        return __( 'Fornavn', 'give' );
    }

    if ( $domain == 'give' && $text == 'Last Name' ) {
        return __( 'Etternavn', 'give' );
    }

    if ( $domain == 'give' && $text == 'Email Address' ) {
        return __( 'E-post', 'give' );
    }

    if ( $domain == 'give' && $text == 'Card Number' ) {
        return __( 'Kortnummer', 'give' );
    }

    if ( $domain == 'give' && $text == 'Cardholder Name' ) {
        return __( 'Kortholders navn', 'give' );
    }

    if ( $domain == 'give' && $text == 'Secure Donation' ) {
        return __( 'Sikker Donasjon', 'give' );
    }

    return $translations;
    
}

/**
 * Conditional for gettext.
 *
 * @param $form_id
 */
function my_give_confirm_form( $form_id ) {

    // Customize form title here or remove conditional for all forms.
    if ( $form_id == 1119 ) {
        add_filter( 'gettext', 'my_give_picky_text_switcher', 10, 3 );
    }
}

add_action( 'give_pre_form_output', 'my_give_confirm_form', 10, 1 );
