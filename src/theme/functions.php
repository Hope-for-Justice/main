<?php

/**
 * Hope for Justice 2021 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hope_for_Justice_2021
 */

if (!defined("_S_VERSION")) {
	// Replace the version number of the theme on each release.
	define("_S_VERSION", "6.2.9");
}

if (!function_exists("hope_for_justice_2021_setup")):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function hope_for_justice_2021_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Hope for Justice 2020, use a find and replace
		 * to change 'hope-for-justice-2020' to the name of your theme in all the template files.
		 */
		load_theme_textdomain(
			"hope-for-justice-2021",
			get_template_directory() . "/languages"
		);

		// Add default posts and comments RSS feed links to head.
		add_theme_support("automatic-feed-links");

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support("title-tag");

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support("post-thumbnails");

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus([
			"primary" => esc_html__("primary", "hope-for-justice-2021"),
			"secondary" => esc_html__("secondary", "hope-for-justice-2021"),
			"footer-a" => esc_html__("footer-a", "hope-for-justice-2021"),
			"footer-b" => esc_html__("footer-b", "hope-for-justice-2021"),
			"footer-c" => esc_html__("footer-c", "hope-for-justice-2021"),
			"footer-d" => esc_html__("footer-d", "hope-for-justice-2021"),
		]);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support("html5", [
			"search-form",
			"comment-form",
			"comment-list",
			"gallery",
			"caption",
		]);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			"custom-background",
			apply_filters("hope_for_justice_2021_custom_background_args", [
				"default-color" => "ffffff",
				"default-image" => "",
			])
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support("customize-selective-refresh-widgets");

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support("custom-logo", [
			"height" => 250,
			"width" => 250,
			"flex-width" => true,
			"flex-height" => true,
		]);
	}
endif;
add_action("after_setup_theme", "hope_for_justice_2021_setup");

/**
 * Enqueue scripts and styles.
 */
function hope_for_justice_2021_scripts()
{
	global $wp_styles;

	//enqueue block scripts in editor

	// if it's using the block template
	if (
		is_page_template("templates/page-block-template.php") ||
		is_tax("event_categories") ||
		is_page_template("templates/page-block-post-template.php") ||
		is_archive() ||
		is_single() ||
		is_search()
	) {
		wp_enqueue_style(
			"hope-for-justice-base-styles",
			get_template_directory_uri() . "/block-base-styles.css",
			[],
			_S_VERSION
		);
	} else {
		wp_enqueue_style(
			"hope-for-justice-2021-style",
			get_stylesheet_uri(),
			[],
			_S_VERSION
		);

		// remove block scripts
		function remove_block_css()
		{
			wp_dequeue_style("wp-block-library");
		}

		add_action("wp_enqueue_scripts", "remove_block_css", 100);
	}

	wp_enqueue_script("jquery");
	// wp_enqueue_script( 'justice-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.modal.js', array(), _S_VERSION, true );
	wp_enqueue_script(
		"hopeforjustice-2021-footer",
		get_template_directory_uri() . "/assets/js/footer.js",
		[],
		_S_VERSION,
		true
	);
}

/**
 * Remove admin bumb*/
add_action("get_header", "my_filter_head");
function my_filter_head()
{
	remove_action("wp_head", "_admin_bar_bump_cb");
}

add_action("wp_enqueue_scripts", "hope_for_justice_2021_scripts", 1);

/**
 * Enqueue page specific scripts in a centrally maintained location
 */
function page_scripts()
{
	global $post;

	// wp_register_script( 'plugins', get_template_directory_uri() . '/assets/js/pages/plugins.js', array('jquery'), _S_VERSION, true);

	wp_register_script(
		"homepage",
		get_template_directory_uri() . "/assets/js/pages/homepage.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"donate",
		get_template_directory_uri() . "/assets/js/pages/donate.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"donate-new",
		get_template_directory_uri() . "/assets/js/pages/donate-new.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"donate-thankyou",
		get_template_directory_uri() . "/assets/js/pages/donate-thankyou.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"donorfy-stripe",
		get_template_directory_uri() . "/assets/js/pages/donorfy-stripe.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"regular-uk",
		get_template_directory_uri() . "/assets/js/pages/regular-uk.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"donorfy-gocardless",
		get_template_directory_uri() . "/assets/js/pages/donorfy-gocardless.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"donorfy-donate",
		get_template_directory_uri() . "/assets/js/pages/donorfy-donate.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"one-off-uk",
		get_template_directory_uri() . "/assets/js/pages/one-off-uk.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"one-off-usa",
		get_template_directory_uri() . "/assets/js/pages/one-off-usa.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"one-off-norway",
		get_template_directory_uri() . "/assets/js/pages/one-off-norway.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"one-off-australia",
		get_template_directory_uri() . "/assets/js/pages/one-off-australia.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"donorfy-webhooks",
		get_template_directory_uri() . "/assets/js/pages/donorfy-webhooks.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"church-partnerships",
		get_template_directory_uri() . "/assets/js/pages/church-partnerships.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"training",
		get_template_directory_uri() . "/assets/js/pages/training.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"freedom-run",
		get_template_directory_uri() . "/assets/js/pages/freedom-run.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"men-are-victims",
		get_template_directory_uri() . "/assets/js/pages/men-are-victims.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"freedom-foundation",
		get_template_directory_uri() . "/assets/js/pages/freedom-foundation.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"governance",
		get_template_directory_uri() . "/assets/js/pages/governance.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"modern-slavery",
		get_template_directory_uri() . "/assets/js/pages/modern-slavery.js",
		["jquery"],
		_S_VERSION,
		true
	);

	wp_register_script(
		"boost-impact",
		get_template_directory_uri() . "/assets/js/pages/boost-impact.js",
		["jquery"],
		_S_VERSION,
		true
	);

	$themeVars = ["template_directory_uri" => get_template_directory_uri()];

	if (is_page()) {
		wp_enqueue_script("plugins");
	}
	if (is_front_page()) {
		wp_enqueue_script("homepage");
	}
	if (
		is_page("donate") ||
		is_page_template("templates/page-basic-campaign.php")
	) {
		wp_enqueue_script("donate");
	}
	if (is_page_template("templates/page-training.php")) {
		wp_enqueue_script("training");
	}
	if (is_page_template("templates/page-freedom-run.php")) {
		wp_enqueue_script("freedom-run");
	}
	if (is_page_template("templates/page-donation-thank-you.php")) {
		wp_enqueue_script("donate-thankyou");
	}
	if (is_page_template("templates/page-guardian-usa.php")) {
		wp_enqueue_script("donorfy-stripe");
		wp_enqueue_script("one-off-usa");
		wp_enqueue_script("donorfy-donate");
	}
	if (is_page_template("templates/page-one-off-uk.php")) {
		wp_enqueue_script("donorfy-stripe");
		wp_enqueue_script("one-off-uk");
		wp_enqueue_script("donorfy-donate");
	}
	if (is_page_template("templates/page-one-off-usa.php")) {
		wp_enqueue_script("donorfy-stripe");
		wp_enqueue_script("one-off-usa");
		wp_enqueue_script("donorfy-donate");
	}
	if (
		is_page_template("templates/page-one-off-norway.php") ||
		is_page_template("templates/page-guardian-norway.php")
	) {
		wp_enqueue_script("donorfy-stripe");
		wp_enqueue_script("one-off-norway");
		wp_enqueue_script("donorfy-donate");
	}
	if (is_page_template("templates/page-one-off-australia.php")) {
		wp_enqueue_script("donorfy-stripe");
		wp_enqueue_script("one-off-australia");
		wp_enqueue_script("donorfy-donate");
	}
	if (is_page_template("templates/page-guardian-australia.php")) {
		wp_enqueue_script("donorfy-stripe");
		wp_enqueue_script("one-off-australia");
		wp_enqueue_script("donorfy-donate");
	}
	if (is_page_template("templates/page-guardian-uk.php")) {
		wp_enqueue_script("regular-uk");
		wp_enqueue_script("donorfy-gocardless");
		wp_enqueue_script("donorfy-donate");
	}
	if (is_page_template("templates/page-donorfy-webhooks.php")) {
		wp_enqueue_script("donorfy-webhooks");
	}
	if (is_page_template("templates/page-donate-new.php")) {
		wp_enqueue_script("donate-new");
	}
	if (is_page_template("templates/page-men-are-victims.php")) {
		wp_enqueue_script("men-are-victims");
		wp_enqueue_style(
			"men-are-victims",
			get_template_directory_uri() . "/men-are-victims.css",
			[],
			_S_VERSION
		);
	}
	if (is_page_template("templates/page-freedom-foundation.php")) {
		wp_enqueue_script("freedom-foundation");
	}
	if (is_page_template("templates/page-goats-milk.php")) {
		wp_enqueue_script("donate-new");
		wp_enqueue_style(
			"goats-milk",
			get_template_directory_uri() . "/goats-milk.css",
			[],
			_S_VERSION
		);
	}
	if (is_page_template("templates/page-church-partnerships.php")) {
		wp_enqueue_script("church-partnerships");
		wp_enqueue_style(
			"church-partnerships",
			get_template_directory_uri() . "/church-partnerships.css",
			[],
			_S_VERSION
		);
	}
	// if (is_page('modern-slavery') || is_page('human-trafficking')) {
	//   wp_enqueue_script('modern-slavery');
	// }
	if (is_page("governance-policies-funding") || is_page("what-we-do")) {
		wp_enqueue_script("governance");
	}
	if (is_tax("event_categories")) {
		wp_enqueue_style(
			"events_styles",
			get_template_directory_uri() . "/template-parts/blocks/events.css",
			[],
			_S_VERSION
		);
		wp_enqueue_style(
			"event_series_styles",
			get_template_directory_uri() . "/template-parts/blocks/event-series.css",
			[],
			_S_VERSION
		);
		wp_enqueue_style(
			"btc_event_series_assets",
			get_template_directory_uri() .
				"/template-parts/blocks/btc-event-series.css",
			[],
			_S_VERSION
		);
	}
}

add_action("wp_enqueue_scripts", "page_scripts", 1);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . "/inc/custom-header.php";

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . "/inc/template-tags.php";

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . "/inc/template-functions.php";

/**
 * Customizer additions.
 */
require get_template_directory() . "/inc/customizer.php";

/**
 * Load Jetpack compatibility file.
 */
if (defined("JETPACK__VERSION")) {
	require get_template_directory() . "/inc/jetpack.php";
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

class GWUnrequire
{
	var $_args = null;

	public function __construct($args = [])
	{
		$this->_args = wp_parse_args($args, [
			"admins_only" => true,
			"require_query_param" => true,
		]);

		add_filter("gform_pre_validation", [$this, "unrequire_fields"]);
	}

	function unrequire_fields($form)
	{
		// if( $this->_args['admins_only'] && ! current_user_can( 'activate_plugins' ) )
		//     return $form;

		if ($this->_args["require_query_param"] && !isset($_GET["gwunrequire"])) {
			return $form;
		}

		foreach ($form["fields"] as &$field) {
			$field["isRequired"] = false;
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
add_filter("gform_stripe_enable_rate_limits", "__return_false");

/**
 * Remove scrolling on submission gravity forms
 */
add_filter("gform_confirmation_anchor", "__return_false");

// archive titles
add_filter("get_the_archive_title", function ($title) {
	if (is_category()) {
		$title = single_cat_title("", false);
	} elseif (is_tag()) {
		$title = single_tag_title("", false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . "</span>";
	} elseif (is_tax()) {
		//for custom post types
		$title = sprintf(__('%1$s'), single_term_title("", false));
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title("", false);
	}
	return $title;
});

function news_page_scripts()
{
	global $wp_styles;
	if (
		is_page_template("category-news-template.php") ||
		is_page_template("all-categories.php") ||
		is_category("blogs_and_opinion_editorials") ||
		is_category("top_news") ||
		is_category("videos") ||
		is_single() ||
		is_category("in_the_headlines") ||
		is_page("search-news-results") ||
		is_page("careers") ||
		is_page("governance-policies-funding") ||
		is_page("resources-template") ||
		is_page("volunteering-opportunities") ||
		is_page("events") ||
		is_singular("events") ||
		is_page("stories-and-case-studies") ||
		is_singular("stories-and-case-studies")
	) {
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

		wp_enqueue_script(
			"news-page-js",
			get_template_directory_uri() . "/assets/js/news-page.js",
			["jquery-core"]
		);
		wp_localize_script("news-page-js", "ajax_object", [
			"ajax_url" => admin_url("admin-ajax.php"),
		]);
	}
}

add_action("wp_enqueue_scripts", "news_page_scripts", 1);

function custom_excerpt_length($length)
{
	return 14;
}
add_filter("excerpt_length", "custom_excerpt_length", 999);

if (function_exists("acf_add_local_field_group")):
	acf_add_local_field_group([
		"key" => "group_60bf926dc01e0",
		"title" => "News Post",
		"fields" => [
			[
				"key" => "field_60bf928245fd0",
				"label" => "Enter Vimeo Link",
				"name" => "upload_video",
				"type" => "oembed",
				"instructions" => "",
				"required" => 0,
				"conditional_logic" => 0,
				"wrapper" => [
					"width" => "",
					"class" => "",
					"id" => "",
				],
				"width" => "",
				"height" => "",
			],
		],
		"location" => [
			[
				[
					"param" => "post_category",
					"operator" => "==",
					"value" => "category:videos",
				],
			],
		],
		"menu_order" => 0,
		"position" => "normal",
		"style" => "default",
		"label_placement" => "top",
		"instruction_placement" => "label",
		"hide_on_screen" => "",
		"active" => true,
		"description" => "",
	]);
endif;

function process_news_form()
{
	// die(print_r($_POST));
	if (
		isset($_POST["action"]) &&
		$_POST["action"] == "news_search" &&
		wp_verify_nonce($_POST["news_nonce"], "news-search-nonce")
	) {
		$redirect = add_query_arg(
			["search" => $_POST["search-posts"], "category" => $_POST["category"]],
			$_POST["redirect"]
		);
		wp_redirect($redirect);
		exit();
	}
}
add_action("init", "process_news_form");

function title_filter($where, $wp_query)
{
	global $wpdb;

	if ($search_term = $wp_query->get("search_news_title")) {
		$where .=
			" AND " .
			$wpdb->posts .
			'.post_title LIKE \'%' .
			esc_sql($wpdb->esc_like($search_term)) .
			'%\'';
	}
	return $where;
}
add_filter(
	"single_template",
	function ($single_template) {
		$parent = "6"; //Change to your category ID
		$categories = get_categories("child_of=" . $parent);
		$cat_names = wp_list_pluck($categories, "name");

		if (has_category("videos")) {
			$single_template = dirname(__FILE__) . "/single-videos.php";
		}
		return $single_template;
	},
	PHP_INT_MAX,
	2
);

/**
 * Gravity Forms scroll top
 */
// add_filter('gform_confirmation_anchor', function () {
//   return 0;
// });

/**
 * better excerpt ending
 */
function new_excerpt_more($more)
{
	return "...";
}
add_filter("excerpt_more", "new_excerpt_more");

/**
 * Custom post types
 */
function create_post_types()
{
	register_post_type("gov_pol_fund", [
		"labels" => [
			"name" => __("GPF Modules"),
			"singular_name" => __("GPF Module"),
		],
		"public" => true,
		"has_archive" => true,
		"rewrite" => [
			"slug" => "gov_pol_fund",
			"with_front" => false,
		],
		"show_in_rest" => true,
		"menu_icon" => "dashicons-text-page",
		"supports" => ["thumbnail", "title", "editor"],
	]);
	register_post_type("resources_template", [
		"labels" => [
			"name" => __("Resources "),
			"singular_name" => __("Resources "),
		],
		"public" => true,
		"has_archive" => true,
		"rewrite" => [
			"slug" => "resources",
			"with_front" => false,
		],
		"show_in_rest" => true,
		"menu_icon" => "dashicons-media-text",
		"supports" => ["thumbnail", "title", "editor"],
	]);
	register_post_type("vol_opp", [
		"labels" => [
			"name" => __("Volunteering Opportunities "),
			"singular_name" => __("Volunteering Opportunity "),
		],
		"public" => true,
		"has_archive" => true,
		"rewrite" => [
			"slug" => "vol_opp",
			"with_front" => false,
		],
		"show_in_rest" => true,
		"menu_icon" => "dashicons-media-document",
		"supports" => ["title"],
	]);

	//events
	register_post_type("events", [
		"labels" => [
			"name" => __("Events"),
			"singular_name" => __("Event"),
			"add_new_item" => __("Add Event"),
			"add_new" => __("Add Event"),
			"edit_item" => __("Edit Event"),
			"featured_image" => __("Event Image"),
			"set_featured_image" => __("Upload Event Image"),
			"remove_featured_image" => __("Remove Event Image"),
			"menu_name" => __("Manage Events"),
		],
		"public" => true,
		"has_archive" => true,
		"rewrite" => [
			"slug" => "events",
			"with_front" => false,
		],
		"show_in_rest" => true,
		"menu_icon" => "dashicons-calendar",
		"supports" => ["thumbnail", "title", "editor"],
	]);

	//stories and case studies
	register_post_type("stories_case_studies", [
		"labels" => [
			"name" => __("Stories and Case Studies"),
			"singular_name" => __("Story and Case Study"),
		],
		"public" => true,
		"has_archive" => true,
		"rewrite" => [
			"slug" => "stories_case_studies",
			"with_front" => false,
		],
		"show_in_rest" => true,
		"menu_icon" => "dashicons-clipboard",
		"supports" => ["thumbnail", "title", "editor"],
	]);

	//publications
	register_post_type("publications", [
		"labels" => [
			"name" => __("Publications"),
			"singular_name" => __("Publication"),
		],
		"public" => true,
		"has_archive" => true,
		"rewrite" => [
			"slug" => "publications",
			"with_front" => false,
		],
		"show_in_rest" => true,
		"menu_icon" => "dashicons-media-text",
		"supports" => ["thumbnail", "title", "editor"],
	]);
}
add_action("init", "create_post_types");

/**
 * Custom taxonomies
 */
function add_custom_taxonomies()
{
	//pages
	register_taxonomy("page_categories", "page", [
		"hierarchical" => true,

		"show_in_rest" => true,

		"labels" => [
			"name" => _x("Categories", "taxonomy general name"),

			"singular_name" => _x("Category", "taxonomy singular name"),

			"search_items" => __("Search Category"),

			"all_items" => __("All Categories"),

			"parent_item" => __("Parent"),

			"parent_item_colon" => __("Parent:"),

			"edit_item" => __("Edit Category"),

			"update_item" => __("Update Category"),

			"add_new_item" => __("Add New Category"),

			"new_item_name" => __("New Category"),

			"menu_name" => __("Categories"),
		],

		"show_in_nav_menus" => false,

		// Control the slugs used for this taxonomy

		"rewrite" => [
			"slug" => "categories", // This controls the base slug that will display before each term

			"with_front" => false, // Don't display the category base before "/locations/"

			"hierarchical" => true, // This will allow URL's like "/locations/boston/cambridge/"
		],
	]);

	//events
	register_taxonomy("event_categories", "events", [
		"hierarchical" => true,

		"show_in_rest" => true,

		"labels" => [
			"name" => _x("Categories", "taxonomy general name"),

			"singular_name" => _x("Category", "taxonomy singular name"),

			"search_items" => __("Search Category"),

			"all_items" => __("All Categories"),

			"parent_item" => __("Parent"),

			"parent_item_colon" => __("Parent:"),

			"edit_item" => __("Edit Category"),

			"update_item" => __("Update Category"),

			"add_new_item" => __("Add New Category"),

			"new_item_name" => __("New Category"),

			"menu_name" => __("Categories"),
		],

		"show_in_nav_menus" => false,

		// Control the slugs used for this taxonomy

		"rewrite" => [
			"slug" => "categories", // This controls the base slug that will display before each term

			"with_front" => false, // Don't display the category base before "/locations/"

			"hierarchical" => true, // This will allow URL's like "/locations/boston/cambridge/"
		],
	]);

	//gov_pol_fund
	register_taxonomy("categories", "gov_pol_fund", [
		"hierarchical" => true,

		"show_ui" => true,
		"show_admin_column" => true,

		"labels" => [
			"name" => _x("Categories", "taxonomy general name"),

			"singular_name" => _x("Category", "taxonomy singular name"),

			"search_items" => __("Search Category"),

			"all_items" => __("All Categories"),

			"parent_item" => __("Parent"),

			"parent_item_colon" => __("Parent:"),

			"edit_item" => __("Edit Category"),

			"update_item" => __("Update Category"),

			"add_new_item" => __("Add New Category"),

			"new_item_name" => __("New Category"),

			"menu_name" => __("Category"),
		],

		"show_in_nav_menus" => true,

		// Control the slugs used for this taxonomy

		"rewrite" => [
			"slug" => "gpf_category", // This controls the base slug that will display before each term

			"with_front" => false, // Don't display the category base before "/locations/"

			"hierarchical" => true, // This will allow URL's like "/locations/boston/cambridge/"
		],
	]);
}

add_action("init", "add_custom_taxonomies", 0);

//acf issue updating fix
add_filter("https_ssl_verify", "__return_false");

if (function_exists("acf_add_options_page")) {
	acf_add_options_page();
}

//shortcodes
include "custom-shortcodes.php";
add_shortcode("dropdown", "dropdown_function");

add_action(
	"give_post_form_output",
	"my_custom_give_populate_amount_name_email"
);

function post_per_page_control($query)
{
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	// For archive.You can omit this
	if (is_archive()) {
		//control the numbers of post displayed/listed (eg here 10)
		$query->set("posts_per_page", 16);
		return;
	}

	// For your tag
	// if ( is_tag() ) {
	//      //control the numbers of post displayed/listed (eg here 10)
	//      $query->set( 'posts_per_page', 10 );
	//      return;
	// }
}
add_action("pre_get_posts", "post_per_page_control");

/* 
Search stuff
*/

// //change button text
// add_filter('get_search_form', 'my_search_form_text');

// function my_search_form_text($text)
// {
//   $text = str_replace('value="Search"', 'value=""', $text); //set as value the text you want
//   return $text;
// }

//limit search to posts and pages

// function search_filter($query)
// {
//   if ($query->is_search) {
//     $query->set('post_type', array('page', 'post'));
//     $query->set('order', 'ASC');
//     $query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1);
//     $query->set('posts_per_page', 10);
//     $query->set('category__not_in', array(5, 6));
//   }
//   return $query;
// }
// add_filter('pre_get_posts', 'search_filter');

// Limit SearchWP results to form field value.
// `sources` is a GET array of post type names.
add_filter(
	"searchwp\query\mods",
	function ($mods, $query) {
		if (empty($_GET["sources"])) {
			return $mods;
		}

		$mod = new \SearchWP\Mod();

		$mod->set_where([
			[
				"column" => "source",
				"value" => array_map(function ($source) {
					return \SearchWP\Utils::get_post_type_source_name($source);
				}, $_GET["sources"]),
				"compare" => "IN",
			],
		]);

		$mods[] = $mod;

		return $mods;
	},
	10,
	2
);

// Limit SearchWP results to chosen post category
// @link https://searchwp.com/documentation/knowledge-base/category-select-dropdown/
add_filter(
	"searchwp\query\mods",
	function ($mods, $query) {
		global $wpdb;

		// Only proceed if a Category was chosen from the dropdown.
		if (
			!isset($_GET["swp_category_limiter"]) ||
			empty(intval($_GET["swp_category_limiter"]))
		) {
			return $mods;
		}

		$alias = "swpkbcat";
		$tax_query = new WP_Tax_Query([
			[
				"taxonomy" => "category",
				"field" => "term_id",
				"terms" => absint($_GET["swp_category_limiter"]),
			],
		]);
		$tq_sql = $tax_query->get_sql($alias, "ID");
		$mod = new \SearchWP\Mod();

		// If the JOIN is empty, WP_Tax_Query assumes we have a JOIN with wp_posts, so let's make that.
		if (!empty($tq_sql["join"])) {
			// Queue the assumed wp_posts JOIN using our alias.
			$mod->raw_join_sql(function ($runtime) use ($wpdb, $alias) {
				return "LEFT JOIN {$wpdb->posts} {$alias} ON {$alias}.ID = {$runtime->get_foreign_alias()}.id";
			});

			// Queue the WP_Tax_Query JOIN which already has our alias.
			$mod->raw_join_sql($tq_sql["join"]);

			// Queue the WP_Tax_Query WHERE which already has our alias.
			$mod->raw_where_sql("1=1 " . $tq_sql["where"]);
		} else {
			// There's no JOIN here because WP_Tax_Query assumes a JOIN with wp_posts already
			// exists. We need to rebuild the tax_query SQL to use a functioning alias. The Mod
			// will ensure the JOIN, and we can use that Mod's alias to rebuild our tax_query.
			$mod->set_local_table($wpdb->posts);
			$mod->on("ID", ["column" => "id"]);

			$mod->raw_where_sql(function ($runtime) use ($tax_query) {
				$tq_sql = $tax_query->get_sql($runtime->get_local_table_alias(), "ID");

				return "1=1 " . $tq_sql["where"];
			});
		}

		$mods[] = $mod;

		return $mods;
	},
	20,
	2
);

// Limit SearchWP results to chosen page category
// @link https://searchwp.com/documentation/knowledge-base/category-select-dropdown/
add_filter(
	"searchwp\query\mods",
	function ($mods, $query) {
		global $wpdb;

		// Only proceed if a Category was chosen from the dropdown.
		if (
			!isset($_GET["swp_page_category_limiter"]) ||
			empty(intval($_GET["swp_page_category_limiter"]))
		) {
			return $mods;
		}

		$alias = "swpkbcatp";
		$tax_query = new WP_Tax_Query([
			[
				"taxonomy" => "page_categories",
				"field" => "term_id",
				"terms" => absint($_GET["swp_page_category_limiter"]),
			],
		]);
		$tq_sql = $tax_query->get_sql($alias, "ID");
		$mod = new \SearchWP\Mod();

		// If the JOIN is empty, WP_Tax_Query assumes we have a JOIN with wp_posts, so let's make that.
		if (!empty($tq_sql["join"])) {
			// Queue the assumed wp_posts JOIN using our alias.
			$mod->raw_join_sql(function ($runtime) use ($wpdb, $alias) {
				return "LEFT JOIN {$wpdb->posts} {$alias} ON {$alias}.ID = {$runtime->get_foreign_alias()}.id";
			});

			// Queue the WP_Tax_Query JOIN which already has our alias.
			$mod->raw_join_sql($tq_sql["join"]);

			// Queue the WP_Tax_Query WHERE which already has our alias.
			$mod->raw_where_sql("1=1 " . $tq_sql["where"]);
		} else {
			// There's no JOIN here because WP_Tax_Query assumes a JOIN with wp_posts already
			// exists. We need to rebuild the tax_query SQL to use a functioning alias. The Mod
			// will ensure the JOIN, and we can use that Mod's alias to rebuild our tax_query.
			$mod->set_local_table($wpdb->posts);
			$mod->on("ID", ["column" => "id"]);

			$mod->raw_where_sql(function ($runtime) use ($tax_query) {
				$tq_sql = $tax_query->get_sql($runtime->get_local_table_alias(), "ID");

				return "1=1 " . $tq_sql["where"];
			});
		}

		$mods[] = $mod;

		return $mods;
	},
	20,
	2
);

/**
 *
 *
 *
 *
 *
 *
 *
 *  * * * * * * * * * * * * * * * * * * * * * *  ACF  * * * * * * * * * * * * * * *
 *
 *
 *
 *
 *
 *
 */

// save json

add_filter("acf/settings/save_json", "my_acf_json_save_point");

function my_acf_json_save_point($path)
{
	// update path
	$path = get_template_directory_uri() . "/acf-json";

	// return
	return $path;
}

// load json

add_filter("acf/settings/load_json", "my_acf_json_load_point");

function my_acf_json_load_point($paths)
{
	// remove original path (optional)
	unset($paths[0]);

	// append path
	$paths[] = get_template_directory_uri() . "/acf-json";

	// return
	return $paths;
}

//remove inner blocks container on front end
add_filter(
	"acf/blocks/wrap_frontend_innerblocks",
	"acf_should_wrap_innerblocks",
	10,
	2
);
function acf_should_wrap_innerblocks($wrap, $name)
{
	if ($name == "acf/test-block") {
		return true;
	}
	return false;
}

/**
 * Responsive Image Helper Function
 *
 * @param string $image_id the id of the image (from ACF or similar)
 * @param string $image_size the size of the thumbnail image or custom image size
 * @param string $max_width the max width this image will be shown to build the sizes attribute
 */

function acf_responsive_image($image_id, $image_size, $max_width)
{
	// check the image ID is not blank
	if ($image_id != "") {
		// set the default src image size
		$image_src = wp_get_attachment_image_url($image_id, $image_size);

		// set the srcset with various image sizes
		$image_srcset = wp_get_attachment_image_srcset($image_id, $image_size);

		// generate the markup for the responsive image
		echo 'src="' .
			$image_src .
			'" srcset="' .
			$image_srcset .
			'" sizes="(max-width: ' .
			$max_width .
			") 100vw, " .
			$max_width .
			'"';
	}
}

add_filter(
	"max_srcset_image_width",
	"awesome_acf_max_srcset_image_width",
	10,
	2
);

// set the max image width
function awesome_acf_max_srcset_image_width()
{
	return 2560;
}

//colour picker acf
function my_acf_input_admin_footer()
{
	?>
  <script type="text/javascript">
    (function($) {

      acf.add_filter('color_picker_args', function(args, $field) {

        // do something to args
        args.palettes = ['#D6001C', '#5CAA7F', '#FFC845', '#8E949E', '#212322', '#ffffff']


        // return
        return args;

      });

    })(jQuery);
  </script>
<?php
}

add_action("acf/input/admin_footer", "my_acf_input_admin_footer");

//add new category
add_filter("block_categories_all", function ($categories) {
	// Adding a new category.
	$categories[] = [
		"slug" => "hfj-design-system",
		"title" => "HfJ Design System",
	];

	return $categories;
});

add_theme_support("align-wide");

//get acf blocks file
require_once __DIR__ . "/acf-blocks.php";

//get core block edits // using plugin setup instead
require_once __DIR__ . "/core-block-edits.php";

//remove paylater gravity forms paypal

add_filter("gform_ppcp_disable_funding", function ($disabled_funding) {
	$disabled_funding[] = "credit"; // PayPal Credit (US, UK).
	$disabled_funding[] = "paylater"; // Pay Later (US, UK), Pay in 4 (AU), 4X PayPal (France), Später Bezahlen (Germany).
	return $disabled_funding;
});
