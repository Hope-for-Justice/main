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

  if (! is_page_template('templates/page-block-template.php')) {
	  wp_enqueue_style( 'hope-for-justice-2021-style', get_stylesheet_uri(), array(), '202275' );
    // remove block scripts
    function remove_block_css(){
      wp_dequeue_style( 'wp-block-library' );
      }
      add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );
  } else {
    wp_enqueue_style( 'hope-for-justice-base-styles', get_template_directory_uri() . '/block-base-styles.css', array(), '202275' );
  }
  
	wp_enqueue_script('jquery'); 
	// wp_enqueue_script( 'justice-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.modal.js', array(), '202275', true );
  wp_enqueue_script( 'hopeforjustice-2021-footer', get_template_directory_uri() . '/assets/js/footer.js', array(), '202275', true );


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

    // wp_register_script( 'plugins', get_template_directory_uri() . '/assets/js/pages/plugins.js', array('jquery'), '202275', true);

    wp_register_script( 'homepage', get_template_directory_uri() . '/assets/js/pages/homepage.js', array('jquery'), '202275', true);

    wp_register_script( 'donate', get_template_directory_uri() . '/assets/js/pages/donate.js', array('jquery'), '202275', true);

    wp_register_script( 'donate-new', get_template_directory_uri() . '/assets/js/pages/donate-new.js', array('jquery'), '202275', true);

    wp_register_script( 'donate-thankyou', get_template_directory_uri() . '/assets/js/pages/donate-thankyou.js', array('jquery'), '202275', true);

    wp_register_script( 'donorfy-stripe', get_template_directory_uri() . '/assets/js/pages/donorfy-stripe.js', array('jquery'), '202275', true);

    wp_register_script( 'regular-uk', get_template_directory_uri() . '/assets/js/pages/regular-uk.js', array('jquery'), '202275', true);

    wp_register_script( 'donorfy-gocardless', get_template_directory_uri() . '/assets/js/pages/donorfy-gocardless.js', array('jquery'), '202275', true);

    wp_register_script( 'donorfy-donate', get_template_directory_uri() . '/assets/js/pages/donorfy-donate.js', array('jquery'), '202275', true);

    wp_register_script( 'one-off-uk', get_template_directory_uri() . '/assets/js/pages/one-off-uk.js', array('jquery'), '202275', true);

    wp_register_script( 'one-off-usa', get_template_directory_uri() . '/assets/js/pages/one-off-usa.js', array('jquery'), '202275', true);

    wp_register_script( 'one-off-norway', get_template_directory_uri() . '/assets/js/pages/one-off-norway.js', array('jquery'), '202275', true);


    wp_register_script( 'donorfy-webhooks', get_template_directory_uri() . '/assets/js/pages/donorfy-webhooks.js', array('jquery'), '202275', true);

    wp_register_script( 'church-partnerships', get_template_directory_uri() . '/assets/js/pages/church-partnerships.js', array('jquery'), '202275', true);

    wp_register_script( 'training', get_template_directory_uri() . '/assets/js/pages/training.js', array('jquery'), '202275', true);

    wp_register_script( 'freedom-run', get_template_directory_uri() . '/assets/js/pages/freedom-run.js', array('jquery'), '202275', true);

    wp_register_script( 'men-are-victims', get_template_directory_uri() . '/assets/js/pages/men-are-victims.js', array('jquery'), '202275', true);


    $themeVars = array( 'template_directory_uri' => get_template_directory_uri() );

    if ( is_page() ) {
      wp_enqueue_script('plugins');
    } 
    if (is_front_page()) {
      wp_enqueue_script('homepage');
    }
    if (is_page('donate') || is_page_template('templates/page-basic-campaign.php')) {
     	wp_enqueue_script('donate');
    }
    if (is_page_template('templates/page-training.php')) {
      wp_enqueue_script('training');
    }
    if (is_page_template('templates/page-freedom-run.php')) {
      wp_enqueue_script('freedom-run');
    }
    if (is_page_template('templates/page-donation-thank-you.php')) {
      wp_enqueue_script('donate-thankyou');
    }
    if (is_page_template('templates/page-guardian-usa.php')) {
      wp_enqueue_script('donorfy-stripe');
      wp_enqueue_script('one-off-usa');
      wp_enqueue_script('donorfy-donate');
    }
    if (is_page_template('templates/page-one-off-uk.php')) {
      wp_enqueue_script('donorfy-stripe');
      wp_enqueue_script('one-off-uk');
      wp_enqueue_script('donorfy-donate');
    }
    if (is_page_template('templates/page-one-off-usa.php')) {
      wp_enqueue_script('donorfy-stripe');
      wp_enqueue_script('one-off-usa');
      wp_enqueue_script('donorfy-donate');
    }
    if (is_page_template('templates/page-one-off-norway.php')) {
      wp_enqueue_script('donorfy-stripe');
      wp_enqueue_script('one-off-norway');
      wp_enqueue_script('donorfy-donate');
    }
    if (is_page_template('templates/page-guardian-uk.php')) {
      wp_enqueue_script('regular-uk');
      wp_enqueue_script('donorfy-gocardless');
      wp_enqueue_script('donorfy-donate');
    }
    if (is_page_template('templates/page-donorfy-webhooks.php')) {
      wp_enqueue_script('donorfy-webhooks');
    }
    if (is_page_template('templates/page-donate-new.php')) {
      wp_enqueue_script('donate-new');
    }
    if (is_page_template('templates/page-men-are-victims.php')) {
      wp_enqueue_script('men-are-victims');
      wp_enqueue_style( 'men-are-victims', get_template_directory_uri() . '/men-are-victims.css', array(), '202275' );
    }
    if (is_page_template('templates/page-goats-milk.php')) {
      wp_enqueue_script('donate-new');
      wp_enqueue_style( 'goats-milk', get_template_directory_uri() . '/goats-milk.css', array(), '202275' );
    }
    if (is_page_template('templates/page-church-partnerships.php')) {
      wp_enqueue_script('church-partnerships');
      wp_enqueue_style( 'church-partnerships', get_template_directory_uri() . '/church-partnerships.css', array(), '202275' );
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
		// if(is_page('volunteering-opportunities') || is_page('events') || is_singular('events')) {
			
		// }
		
		
		
	
		// wp_enqueue_style( 'news-page-css', get_template_directory_uri() . '/assets/css/news-page.css' );
		// wp_enqueue_style( 'gov-pol-fund-css', get_template_directory_uri() . '/assets/css/gov-pol-fund.css' );
		// wp_enqueue_style( 'resources-template-css', get_template_directory_uri() . '/assets/css/resources-template.css' );
		// wp_enqueue_style( 'volunteering-opportunities-css', get_template_directory_uri() . '/assets/css/volunteering-opportunities.css' );
		// wp_enqueue_style( 'events-css', get_template_directory_uri() . '/assets/css/events.css' );
    //     wp_enqueue_style( 'case-studies-css', get_template_directory_uri() . '/assets/css/case-studies.css' );
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
      'rewrite' => array(
        'slug' => 'gov_pol_fund',
        'with_front' => FALSE
      ),
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
      'rewrite' => array(
        'slug' => 'resources',
        'with_front' => FALSE
      ),
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
      'rewrite' => array(
        'slug' => 'vol_opp',
        'with_front' => FALSE
      ),
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
      'rewrite' => array(
        'slug' => 'stories_case_studies',
        'with_front' => FALSE
      ),
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





//acf issue updating fix
add_filter( 'https_ssl_verify', '__return_false' );

if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page();
  
}

//shortcodes
include('custom-shortcodes.php');
add_shortcode('dropdown', 'dropdown_function');


add_action( 'give_post_form_output', 'my_custom_give_populate_amount_name_email' );




/**
 * Responsive Image Helper Function
 *
 * @param string $image_id the id of the image (from ACF or similar)
 * @param string $image_size the size of the thumbnail image or custom image size
 * @param string $max_width the max width this image will be shown to build the sizes attribute 
 */

function acf_responsive_image($image_id,$image_size,$max_width){

  // check the image ID is not blank
  if($image_id != '') {

    // set the default src image size
    $image_src = wp_get_attachment_image_url( $image_id, $image_size );

    // set the srcset with various image sizes
    $image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );

    // generate the markup for the responsive image
    echo 'src="'.$image_src.'" srcset="'.$image_srcset.'" sizes="(max-width: '.$max_width.') 100vw, '.$max_width.'"';

  }
}

add_filter( 'max_srcset_image_width', 'awesome_acf_max_srcset_image_width', 10 , 2 );

// set the max image width 
function awesome_acf_max_srcset_image_width() {
  return 2560;
} 

// function for css for custom blocks - only load whats needed
// usage 
// $name = "block-content-image";
// <section class="block-content-images">
// <?php loadStyles( __DIR__, $name ); 
// </section> 

// function loadStyles($path, $name, $file_name = 'style', $echo = true){
//   global $blocksLoaded;

//   if (!in_array($name, $blocksLoaded)) {
//       $html = '';
//       $file = "$path/$file_name.css";

//       if (file_exists($file)) {
//           $style_content = file_get_contents($file);

//           if ($style_content !== '') {
//               $html = '<style>' . $style_content .'</style>';
//               array_push($blocksLoaded, $name);

//               if ($echo) {
//                   echo $html;
//               } else {
//                   return $html;
//               }

//           }
//       }
//   }
// }



function remove_default_blocks($allowed_blocks){
 
    // Get all registered blocks
    $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
    
    // Remove all blocks that are prefixed with core/rss
    $filtered_blocks = array();
    foreach($registered_blocks as $block) {
     
      if(strpos($block->name , 'core/rss') === false) { 
        array_push($filtered_blocks, $block->name);
      }
    }
    
    return $filtered_blocks;
}

//remove editor styles
// add_action('enqueue_block_editor_assets', function () {
//   // Remove editor style resets
//   wp_deregister_style('wp-reset-editor-styles');
// }, 102);

// Remove default WP blocks editor styles
// add_action('after_setup_theme', function() {
//   remove_editor_styles();
//   add_theme_support('editor-styles');
//   add_editor_style('editor-styles.css');
// });

//add new category
add_filter( 'block_categories_all' , function( $categories ) {

  // Adding a new category.
$categories[] = array(
  'slug'  => 'hfj-design-system',
  'title' => 'HfJ Design System'
);

return $categories;
} );

add_filter('allowed_block_types', 'remove_default_blocks');
add_theme_support( 'align-wide' );

add_action( 'enqueue_block_editor_assets', function() {
  wp_enqueue_style( 'hope-for-justice-base-styles', get_template_directory_uri() . '/editor-block-base-styles.css', array(), '202275' );
} );

//acf block types
add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {


        // // register grid block.
        // acf_register_block_type(array(
        //     'name'              => 'grid',
        //     'title'             => __('Grid 12 col'),
        //     'description'       => __('Custom HfJ block. Grid for layout.'),
        //     'render_template'   => 'template-parts/blocks/grid/grid.php',
        //     'category'          => 'hfj-design-system',
        //     'icon'              => 'grid-view',
        //     'keywords'          => array( 'grid', 'layout',),
        //     'align'           => 'wide', 
        //     'supports'		=> [
        //       'anchor'		=> true,
        //       'customClassName'	=> true,
        //       'jsx' 			=> true,
        //     ]         
        // ));

      //   // register grid-inner block.
      //   acf_register_block_type(array(
      //       'name'              => 'grid-inner',
      //       'title'             => __('Grid inner'),
      //       'description'       => __('Custom HfJ block. Grid inner for layout.'),
      //       'render_template'   => 'template-parts/blocks/grid/grid-inner.php',
      //       'category'          => 'hfj-design-system',
      //       'icon'              => 'grid-view',
      //       'keywords'          => array( 'grid', 'layout',),
      //       'align'           => 'wide', 
      //       'enqueue_assets'    => 'grid_inner_assets',
      //       'supports'		=> [
      //         'anchor'		=> true,
      //         'customClassName'	=> true,
      //         'jsx' 			=> true,
      //       ]         
      //   ));

      //   function grid_inner_assets(){
      //     wp_enqueue_style('grid-inner', get_template_directory_uri() . '/template-parts/blocks/grid-inner.css');
      // }
      
        // register full-header-fk-screamer block.
        acf_register_block_type(array(
            'name'              => 'full-header-fk-screamer',
            'title'             => __('Full header - FK Screamer'),
            'description'       => __('Custom HfJ block. Full header for the top of a page'),
            'render_template'   => 'template-parts/blocks/full-header-fk-screamer/full-header-fk-screamer.php',
            'category'          => 'hfj-design-system',
            'icon'              => 'cover-image',
            'keywords'          => array( 'full header', 'header', 'title' ),
            'enqueue_assets'    => 'full_header_fk_assets',
            'align'           => 'wide',           
        ));

        function full_header_fk_assets(){
            wp_enqueue_style('full-header-fk-screamer', get_template_directory_uri() . '/template-parts/blocks/block-full-header-fk-screamer.css');
        }

        // register full-width-text block.
        acf_register_block_type(array(
          'name'              => 'text',
          'title'             => __('Text'),
          'description'       => __('Custom HfJ block. Full width text with max width'),
          'render_template'   => 'template-parts/blocks/text/text.php',
          'category'          => 'hfj-design-system',
          'icon'              => 'text',
          'enqueue_assets'    => 'text_assets',        
        ));

        function text_assets(){
            wp_enqueue_style('full-width-text', get_template_directory_uri() . '/template-parts/blocks/block-text.css');
        }

        //register title block.
        acf_register_block_type(array(
          'name'              => 'title',
          'title'             => __('Title'),
          'description'       => __('Custom HfJ block. For all types of titles'),
          'render_template'   => 'template-parts/blocks/title/title.php',
          'category'          => 'hfj-design-system',
          'icon'              => 'text', 
          'enqueue_assets'    => 'title_assets',        
        ));

        function title_assets(){
            wp_enqueue_style('title-assets', get_template_directory_uri() . '/template-parts/blocks/block-title.css');
        }

        //register two-col-title-and-text block.
        acf_register_block_type(array(
          'name'              => 'two-col-title-and-text',
          'title'             => __('Title and text - 2 columns'),
          'description'       => __('Custom HfJ block. Two titles and two bits of text.'),
          'render_template'   => 'template-parts/blocks/title-and-text/two-col-title-and-text.php',
          'category'          => 'hfj-design-system',
          'icon'              => 'text', 
          'enqueue_assets'    => 'title_and_text_2col_assets',        
        ));

        function title_and_text_2col_assets(){
            wp_enqueue_style('title_and_text_2col_assets', get_template_directory_uri() . '/template-parts/blocks/two-col-title-and-text.css');
        }

        //register card block.
        acf_register_block_type(array(
          'name'              => 'cards-thirds',
          'title'             => __('Cards - Thirds'),
          'description'       => __('Custom HfJ cards. Best to have either 3 or 6 cards.'),
          'render_template'   => 'template-parts/blocks/card/cards-thirds.php',
          'category'          => 'hfj-design-system',
          'icon'              => 'cover-image', 
          'enqueue_assets'    => 'card_third_assets',        
        ));

        function card_third_assets(){
            wp_enqueue_style('card_third_assets', get_template_directory_uri() . '/template-parts/blocks/card-thirds.css');
        }
    

    }
}

// function custom_block_styles() {

//   wp_enqueue_script( 'block-scripts',  get_template_directory_uri() . '/assets/js/block-scripts.js' );
//   wp_enqueue_style( 'block-styles',  get_template_directory_uri() . '/block-styles.css' );
// }
// add_action( 'after_setup_theme', 'custom_block_styles' );