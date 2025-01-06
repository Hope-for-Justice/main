<?php

add_action("enqueue_block_editor_assets", function () {
	wp_enqueue_style(
		"hope-for-justice-base-styles",
		get_template_directory_uri() . "/editor-block-base-styles.css",
		[],
		_S_VERSION
	);
});

//acf block types
add_action("acf/init", "my_acf_init_block_types");
function my_acf_init_block_types()
{
	// Check function exists.
	if (function_exists("acf_register_block_type")) {
		// register full-header-fk-screamer block.
		acf_register_block_type([
			"name" => "full-header",
			"title" => __("Full header"),
			"description" => __(
				"Custom HfJ block. Full header for the top of a page"
			),
			"render_template" => "template-parts/blocks/full-header/full-header.php",
			"category" => "hfj-design-system",
			"icon" => "cover-image",
			"keywords" => ["full header", "header", "title"],
			"enqueue_assets" => "full_header",
			"supports" => [
				"jsx" => true,
			],
		]);

		// function full_header()
		// {
		//     wp_enqueue_style('full-header', get_template_directory_uri() . '/template-parts/blocks/full-header.css', array(), _S_VERSION);
		// }

		// register text block.
		acf_register_block_type([
			"name" => "text",
			"title" => __("Text"),
			"description" => __("Custom HfJ block. Full width text with max width"),
			"render_template" => "template-parts/blocks/text/text.php",
			"category" => "hfj-design-system",
			"icon" => "text",
			"enqueue_assets" => "text_assets",
			"supports" => [
				"align" => ["center"],
			],
		]);

		function text_assets()
		{
			wp_enqueue_style(
				"block-text",
				get_template_directory_uri() . "/template-parts/blocks/block-text.css",
				[],
				_S_VERSION
			);
		}

		//register title block.
		acf_register_block_type([
			"name" => "title",
			"title" => __("Title"),
			"description" => __("Custom HfJ block. For all types of titles"),
			"render_template" => "template-parts/blocks/title/title.php",
			"category" => "hfj-design-system",
			"icon" => "text",
			"enqueue_assets" => "title_assets",
			"supports" => [
				"align" => ["center"],
			],
		]);

		// function title_assets()
		// {
		//     wp_enqueue_style('title-assets', get_template_directory_uri() . '/template-parts/blocks/block-title.css', array(), _S_VERSION);
		// }

		//register two-col-title-and-text block.
		acf_register_block_type([
			"name" => "two-col-title-and-text",
			"title" => __("Title and text - 2 columns"),
			"description" => __("Custom HfJ block. Two titles and two bits of text."),
			"render_template" =>
				"template-parts/blocks/title-and-text/two-col-title-and-text.php",
			"category" => "hfj-design-system",
			"icon" => "text",
			"enqueue_assets" => "title_and_text_2col_assets",
		]);

		// function title_and_text_2col_assets()
		// {
		//     wp_enqueue_style('title_and_text_2col_assets', get_template_directory_uri() . '/template-parts/blocks/two-col-title-and-text.css', array(), _S_VERSION);
		// }

		//register cards thirds block.
		acf_register_block_type([
			"name" => "cards-thirds",
			"title" => __("Cards - Thirds"),
			"description" => __(
				"Custom HfJ cards. Best to have either 3 or 6 cards."
			),
			"render_template" => "template-parts/blocks/cards/cards-thirds.php",
			"category" => "hfj-design-system",
			"icon" => "cover-image",
			"enqueue_assets" => "card_third_assets",
		]);

		function card_third_assets()
		{
			// wp_enqueue_style('card_third_styles', get_template_directory_uri() . '/template-parts/blocks/cards-thirds.css', array(), _S_VERSION);
			wp_enqueue_script(
				"card_scripts",
				get_template_directory_uri() .
					"/template-parts/blocks/cards/cards-scripts.js",
				[],
				_S_VERSION
			);
		}

		//register big image card block.
		acf_register_block_type([
			"name" => "big-image-card",
			"title" => __("Big Image Card"),
			"description" => __("Custom HfJ card. Big Image Card."),
			"render_template" => "template-parts/blocks/cards/big-image-card.php",
			"category" => "hfj-design-system",
			"icon" => "cover-image",
			"enqueue_assets" => "big_image_card_assets",
		]);

		// function big_image_card_assets()
		// {
		//     wp_enqueue_style('big_image_card_assets', get_template_directory_uri() . '/template-parts/blocks/big-image-card.css', array(), _S_VERSION);
		// }

		//register button block.
		acf_register_block_type([
			"name" => "button",
			"title" => __("Button"),
			"description" => __("Custom HfJ button."),
			"render_template" => "template-parts/blocks/button/button.php",
			"category" => "hfj-design-system",
			"icon" => "button",
			"enqueue_assets" => "button_assets",
		]);

		// function button_assets()
		// {
		//     wp_enqueue_style('button_assets', get_template_directory_uri() . '/template-parts/blocks/button.css', array(), _S_VERSION);
		// }

		//register card half block.
		acf_register_block_type([
			"name" => "cards-half",
			"title" => __("Cards - Halves"),
			"description" => __(
				"Custom HfJ cards. Best to have either a multiple of 2."
			),
			"render_template" => "template-parts/blocks/cards/cards-half.php",
			"category" => "hfj-design-system",
			"icon" => "cover-image",
			"enqueue_assets" => "card_half_assets",
		]);

		// function card_half_assets()
		// {
		//     wp_enqueue_style('card_half_assets', get_template_directory_uri() . '/template-parts/blocks/cards-half.css', array(), _S_VERSION);
		// }

		//register event header block
		acf_register_block_type([
			"name" => "event-header",
			"title" => __("Event - Header"),
			"description" => __(
				"Use to show the title, time and location of the current event post"
			),
			"render_template" =>
				"template-parts/blocks/event-header/event-header.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "event_header_assets",
		]);

		// function event_header_assets()
		// {
		//     wp_enqueue_style('event_header_assets', get_template_directory_uri() . '/template-parts/blocks/event-header.css', array(), _S_VERSION);
		// }

		//register event categories block
		acf_register_block_type([
			"name" => "event-categories",
			"title" => __("Event - Categories"),
			"description" => __(
				"Use to show the title, time and location of the current event post"
			),
			"render_template" =>
				"template-parts/blocks/event-categories/event-categories.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "event_header_assets",
		]);

		// function event_categories_assets()
		// {
		//     wp_enqueue_style('event_categories_assets', get_template_directory_uri() . '/template-parts/blocks/event-categories.css', array(), _S_VERSION);
		// }

		//register donate block
		acf_register_block_type([
			"name" => "donate-block",
			"title" => __("Donate block"),
			"description" => __("International donate widget"),
			"render_template" =>
				"template-parts/blocks/donate-block/donate-block.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "donate_block_assets",
			"supports" => [
				"jsx" => true,
			],
		]);

		function donate_block_assets()
		{
			// wp_enqueue_style('donate_block_styles', get_template_directory_uri() . '/template-parts/blocks/donate-block.css', array(), _S_VERSION);

			wp_enqueue_script(
				"donate_block_scripts",
				get_template_directory_uri() .
					"/template-parts/blocks/donate-block/donate-block.js",
				["jquery"],
				_S_VERSION
			);
		}

		//register form block
		acf_register_block_type([
			"name" => "form-block",
			"title" => __("Form"),
			"description" => __(
				"Custom form block. Put a gravity form inside this block"
			),
			"render_template" => "template-parts/blocks/form-block/form-block.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "form_block_assets",
			"supports" => [
				"jsx" => true,
			],
		]);

		// function form_block_assets()
		// {
		//     wp_enqueue_style('form_block_styles', get_template_directory_uri() . '/template-parts/blocks/form-block.css', array(), _S_VERSION);
		// }

		//register event series block
		acf_register_block_type([
			"name" => "event-series",
			"title" => __("Event Series"),
			"description" => __(
				"Shows upcoming events in a category with an advert for that category"
			),
			"render_template" =>
				"template-parts/blocks/event-series/event-series.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "event_series_assets",
			"supports" => [
				"jsx" => true,
			],
		]);

		// function event_series_assets()
		// {
		//     wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
		// }

		//register spacer block
		acf_register_block_type([
			"name" => "hfj-spacer",
			"title" => __("Spacer"),
			"description" => __("HfJ responsive spacer"),
			"render_template" => "template-parts/blocks/spacer/spacer.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "spacer_assets",
		]);

		// function spacer_assets()
		// {
		//     wp_enqueue_style('spacer_assets', get_template_directory_uri() . '/template-parts/blocks/spacer.css', array(), _S_VERSION);
		// }

		//register btc event series
		acf_register_block_type([
			"name" => "btc-event-series",
			"title" => __("BTC Event series"),
			"description" => __("Displays BTC events"),
			"render_template" =>
				"template-parts/blocks/btc-event-series/btc-event-series.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "btc_event_series_assets",
		]);

		// function btc_event_series_assets()
		// {
		//     wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
		//     wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
		// }

		//register events block
		acf_register_block_type([
			"name" => "events",
			"title" => __("Events Block"),
			"description" => __("Displays events"),
			"render_template" => "template-parts/blocks/events/events.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "events_assets",
		]);

		// function events_assets()
		// {
		//     wp_enqueue_style('events_styles', get_template_directory_uri() . '/template-parts/blocks/events.css', array(), _S_VERSION);
		//     wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
		//     wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
		// }

		//register btc event series
		acf_register_block_type([
			"name" => "btc-header",
			"title" => __("BTC Header"),
			"description" => __("BTC page header"),
			"render_template" => "template-parts/blocks/btc-header/btc-header.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "btc_header_assets",
		]);

		// function btc_header_assets()
		// {
		//     wp_enqueue_style('btc_header_styles', get_template_directory_uri() . '/template-parts/blocks/btc-header.css', array(), _S_VERSION);
		// }

		//register image and text
		acf_register_block_type([
			"name" => "image-and-text",
			"title" => __("Image and Text"),
			"description" => __("Block for image and text"),
			"render_template" =>
				"template-parts/blocks/image-and-text/image-and-text.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "image_text_assets",
		]);

		// function image_text_assets()
		// {
		//     wp_enqueue_style('image_text_styles', get_template_directory_uri() . '/template-parts/blocks/image-and-text.css', array(), _S_VERSION);
		// }

		//register image
		acf_register_block_type([
			"name" => "image",
			"title" => __("Image"),
			"description" => __("Block for image"),
			"render_template" => "template-parts/blocks/image/image.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "image_assets",
			"supports" => [
				"align" => ["center"],
			],
		]);

		// function image_assets()
		// {
		//     wp_enqueue_style('image_styles', get_template_directory_uri() . '/template-parts/blocks/image.css', array(), _S_VERSION);
		// }

		//register dropdown
		acf_register_block_type([
			"name" => "dropdown",
			"title" => __("Dropdown"),
			"description" => __("Block for a dropdown"),
			"render_template" => "template-parts/blocks/dropdown/dropdown.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "dropdown_assets",
		]);

		function dropdown_assets()
		{
			// wp_enqueue_style('dropdown_styles', get_template_directory_uri() . '/template-parts/blocks/dropdown.css', array(), _S_VERSION);
			wp_enqueue_script(
				"dropdown_scripts",
				get_template_directory_uri() .
					"/template-parts/blocks/dropdown/dropdown.js",
				["jquery"],
				_S_VERSION
			);
		}

		//register social
		acf_register_block_type([
			"name" => "social",
			"title" => __("Socials"),
			"description" => __("Block for a socials"),
			"render_template" => "template-parts/blocks/social/social.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "social_assets",
		]);

		// function social_assets()
		// {
		//     wp_enqueue_style('social_styles', get_template_directory_uri() . '/template-parts/blocks/social.css', array(), _S_VERSION);
		// }
		//register geo-target
		acf_register_block_type([
			"name" => "geo-target",
			"title" => __("Geo-target"),
			"description" => __("Geo-target content inside this block"),
			"render_template" => "template-parts/blocks/geo-target/geo-target.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "geo_target_assets",
			"supports" => [
				"jsx" => true,
			],
		]);

		// function geo_target_assets()
		// {
		//     wp_enqueue_style('geo_target_styles', get_template_directory_uri() . '/template-parts/blocks/geo-target.css', array(), _S_VERSION);
		// }

		//register video-modal
		acf_register_block_type([
			"name" => "video-modal",
			"title" => __("Video modal"),
			"description" => __(
				"Video modal no configuration needed but link must be setup"
			),
			"render_template" => "template-parts/blocks/video-modal/video-modal.php",
			"category" => "hfj-design-system",
		]);

		//register cta-grid
		acf_register_block_type([
			"name" => "cta-grid",
			"title" => __("CTA Grid"),
			"description" => __("Grid of call to action cards"),
			"render_template" => "template-parts/blocks/cta-grid/cta-grid.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "cta_grid_assets",
		]);

		// function cta_grid_assets()
		// {
		//     wp_enqueue_style('cta_grid_styles', get_template_directory_uri() . '/template-parts/blocks/cta-grid.css', array(), _S_VERSION);
		// }

		//register cards-quarters
		acf_register_block_type([
			"name" => "cards-quarter",
			"title" => __("Cards quarters"),
			"description" => __("Quarter cards. Add 4."),
			"render_template" => "template-parts/blocks/cards/cards-quarter.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "card_quarter_assets",
		]);

		function card_quarter_assets()
		{
			// wp_enqueue_style('card_quarter_styles', get_template_directory_uri() . '/template-parts/blocks/cards-quarter.css', array(), _S_VERSION);
			wp_enqueue_script(
				"card_scripts",
				get_template_directory_uri() .
					"/template-parts/blocks/cards/cards-scripts.js",
				[],
				_S_VERSION
			);
		}

		//register posts block
		acf_register_block_type([
			"name" => "posts-block",
			"title" => __("Posts Block"),
			"description" => __("Custom query post block"),
			"render_template" => "template-parts/blocks/posts/posts.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "post_block_assets",
		]);

		// function post_block_assets()
		// {
		//     wp_enqueue_style('post_block_styles', get_template_directory_uri() . '/template-parts/blocks/posts.css', array(), _S_VERSION);
		// }

		//register accordion block
		acf_register_block_type([
			"name" => "accordion",
			"title" => __("Accordion"),
			"description" => __("Custom accordion block"),
			"render_template" => "template-parts/blocks/accordion/accordion.php",
			"category" => "hfj-design-system",
			"enqueue_assets" => "accordion_assets",
			"supports" => [
				"jsx" => true,
			],
		]);

		function accordion_assets()
		{
			// wp_enqueue_style('accordion_styles', get_template_directory_uri() . '/template-parts/blocks/accordion.css', array(), _S_VERSION);
			wp_enqueue_script(
				"accordion_scripts",
				get_template_directory_uri() .
					"/template-parts/blocks/accordion/accordion.js",
				["jquery"],
				_S_VERSION
			);
		}

		//register accordion header
		acf_register_block_type([
			"name" => "accordion-header",
			"title" => __("Accordion Header"),
			"description" => __("Accordion header block"),
			"render_template" =>
				"template-parts/blocks/accordion/accordion-header.php",
			"category" => "hfj-design-system",
			"supports" => [
				"jsx" => true,
			],
		]);

		//register accordion content
		acf_register_block_type([
			"name" => "accordion-content",
			"title" => __("Accordion Content"),
			"description" => __("Accordion content block"),
			"render_template" =>
				"template-parts/blocks/accordion/accordion-content.php",
			"category" => "hfj-design-system",
			"supports" => [
				"jsx" => true,
			],
		]);

		//register featured stories
		acf_register_block_type([
			"name" => "featured-stories",
			"title" => __("Featured Stories"),
			"description" => __("Featured Stories block"),
			"render_template" =>
				"template-parts/blocks/featured-stories/featured-stories.php",
			"category" => "hfj-design-system",
		]);

		//register carousel
		acf_register_block_type([
			"name" => "carousel",
			"title" => __("Carousel"),
			"description" => __("Carousel block"),
			"render_template" => "template-parts/blocks/carousel/carousel.php",
			"category" => "hfj-design-system",
		]);

		//register grid break
		acf_register_block_type([
			"name" => "grid-break",
			"title" => __("Grid Break"),
			"description" => __(
				"Grid Break block. Place blocks inside to ignore the bounds of an article in a news post"
			),
			"render_template" => "template-parts/blocks/grid-break/grid-break.php",
			"category" => "hfj-design-system",
			"supports" => [
				"jsx" => true,
			],
		]);

		//register grid block
		acf_register_block_type([
			"name" => "grid-block",
			"title" => __("Grid Block"),
			"description" => __("Grid Block. Make your own layout!"),
			"render_template" => "template-parts/blocks/grid/grid.php",
			"category" => "hfj-design-system",
			"acf_block_version" => "2",
			"supports" => [
				"jsx" => true,
			],
		]);

		//register grid container
		acf_register_block_type([
			"name" => "grid-container",
			"title" => __("Grid Container"),
			"description" => __("Grid Container. Make your own layout!"),
			"render_template" => "template-parts/blocks/grid/grid-container.php",
			"category" => "hfj-design-system",
			"acf_block_version" => "2",
			"supports" => [
				"jsx" => true,
			],
		]);

		//register resources block
		acf_register_block_type([
			"name" => "resources-block",
			"title" => __("Resources Block"),
			"description" => __(""),
			"render_template" => "template-parts/blocks/resources/resources.php",
			"category" => "hfj-design-system",
		]);

		//register publications block
		acf_register_block_type([
			"name" => "publications-block",
			"title" => __("Publications Block"),
			"description" => __(""),
			"render_template" =>
				"template-parts/blocks/publications/publications.php",
			"category" => "hfj-design-system",
		]);

		//register modal block
		acf_register_block_type([
			"name" => "modal",
			"title" => __("Modal block"),
			"description" => __("Modal block for HfJ"),
			"render_template" => "template-parts/blocks/modal/modal.php",
			"category" => "hfj-design-system",
			"acf_block_version" => "2",
			"supports" => [
				"jsx" => true,
			],
		]);

		//register gpf block
		acf_register_block_type([
			"name" => "gpf-block",
			"title" => __("GPF Block"),
			"description" => __(""),
			"render_template" =>
				"template-parts/blocks/gpf-documents/gpf-documents.php",
			"category" => "hfj-design-system",
		]);

		//register careers block
		acf_register_block_type([
			"name" => "careers-block",
			"title" => __("Careers Block"),
			"description" => __(""),
			"render_template" => "template-parts/blocks/careers/careers.php",
			"category" => "hfj-design-system",
		]);

		//register pre donation block
		acf_register_block_type([
			"name" => "pre-donation",
			"title" => __("Pre Donation Block"),
			"description" => __("Used to ask the user how they would like to donate"),
			"render_template" =>
				"template-parts/blocks/pre-donation/pre-donation.php",
			"category" => "hfj-design-system",
		]);

		//register other ways to donate block
		acf_register_block_type([
			"name" => "other-ways-to-give",
			"title" => __("Other ways to give block"),
			"description" => __(""),
			"render_template" =>
				"template-parts/blocks/other-ways-to-give/other-ways-to-give.php",
			"category" => "hfj-design-system",
		]);
	}
}

/**
 * Register the styles (CSS) for the blocks outside
 * acf_register_block_type() as loading styles
 * using acf_register_block_type() will load the
 * styles in the footer and not in <head> causing
 * CLS issues
 */
add_action("wp_enqueue_scripts", "register_acf_block_styles");
add_action("admin_enqueue_scripts", "register_acf_block_styles");

function register_acf_block_styles(): void
{
	//allways enqueue block-title and block text
	// wp_enqueue_style('block-text', get_template_directory_uri() . '/template-parts/blocks/block-text.css', array(), _S_VERSION);
	// wp_enqueue_style('title-assets', get_template_directory_uri() . '/template-parts/blocks/block-title.css', array(), _S_VERSION);
	// wp_enqueue_style('post_block_styles', get_template_directory_uri() . '/template-parts/blocks/posts.css', array(), _S_VERSION);

	// if (has_block('acf/full-header')) {
	//     wp_enqueue_style('full-header', get_template_directory_uri() . '/template-parts/blocks/full-header.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/two-col-title-and-text')) {
	//     wp_enqueue_style('title_and_text_2col_assets', get_template_directory_uri() . '/template-parts/blocks/two-col-title-and-text.css', array(), _S_VERSION);
	// }

	if (has_block("acf/cards-thirds")) {
		// wp_enqueue_style('card_third_styles', get_template_directory_uri() . '/template-parts/blocks/cards-thirds.css', array(), _S_VERSION);
		wp_enqueue_script(
			"card_scripts",
			get_template_directory_uri() .
				"/template-parts/blocks/cards/cards-scripts.js",
			[],
			_S_VERSION
		);
	}

	// if (has_block('acf/big-image-card')) {
	//     // wp_enqueue_style('big_image_card_assets', get_template_directory_uri() . '/template-parts/blocks/big-image-card.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/button')) {
	//     wp_enqueue_style('button_assets', get_template_directory_uri() . '/template-parts/blocks/button.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/cards-half')) {
	//     wp_enqueue_style('card_half_assets', get_template_directory_uri() . '/template-parts/blocks/cards-half.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/event-header')) {
	//     wp_enqueue_style('event_header_assets', get_template_directory_uri() . '/template-parts/blocks/event-header.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/event-categories')) {
	//     wp_enqueue_style('event_categories_assets', get_template_directory_uri() . '/template-parts/blocks/event-categories.css', array(), _S_VERSION);
	// }

	if (has_block("acf/donate-block")) {
		// wp_enqueue_style('donate_block_assets', get_template_directory_uri() . '/template-parts/blocks/donate-block.css', array(), _S_VERSION);

		wp_enqueue_script(
			"donate_block_scripts",
			get_template_directory_uri() .
				"/template-parts/blocks/donate-block/donate-block.js",
			[],
			_S_VERSION
		);
	}

	// if (has_block('acf/form-block')) {
	//     wp_enqueue_style('form_block_styles', get_template_directory_uri() . '/template-parts/blocks/form-block.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/event-series')) {
	//     wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/hfj-spacer')) {
	//     wp_enqueue_style('spacer_assets', get_template_directory_uri() . '/template-parts/blocks/spacer.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/btc-event-series')) {
	//     wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
	//     wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/events')) {
	//     wp_enqueue_style('events_styles', get_template_directory_uri() . '/template-parts/blocks/events.css', array(), _S_VERSION);
	//     wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
	//     wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/btc-header')) {
	//     wp_enqueue_style('btc_header_styles', get_template_directory_uri() . '/template-parts/blocks/btc-header.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/image-and-text')) {
	//     wp_enqueue_style('image_text_styles', get_template_directory_uri() . '/template-parts/blocks/image-and-text.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/image')) {
	//     wp_enqueue_style('image_styles', get_template_directory_uri() . '/template-parts/blocks/image.css', array(), _S_VERSION);
	// }

	if (has_block("acf/dropdown")) {
		// wp_enqueue_style('dropdown_styles', get_template_directory_uri() . '/template-parts/blocks/dropdown.css', array(), _S_VERSION);
		wp_enqueue_script(
			"dropdown_scripts",
			get_template_directory_uri() .
				"/template-parts/blocks/dropdown/dropdown.js",
			["jquery"],
			_S_VERSION
		);
	}

	// if (has_block('acf/social')) {
	//     wp_enqueue_style('social_styles', get_template_directory_uri() . '/template-parts/blocks/social.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/geo-target')) {
	//     wp_enqueue_style('geo_target_styles', get_template_directory_uri() . '/template-parts/blocks/geo-target.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/cta-grid')) {
	//     wp_enqueue_style('cta_grid_styles', get_template_directory_uri() . '/template-parts/blocks/cta-grid.css', array(), _S_VERSION);
	// }

	if (has_block("acf/cards-quarter")) {
		// wp_enqueue_style('cards_quarter_styles', get_template_directory_uri() . '/template-parts/blocks/cards-quarter.css', array(), _S_VERSION);
		wp_enqueue_script(
			"card_scripts",
			get_template_directory_uri() .
				"/template-parts/blocks/cards/cards-scripts.js",
			[],
			_S_VERSION
		);
	}

	// if (has_block('acf/posts-block')) {
	//     wp_enqueue_style('post_block_styles', get_template_directory_uri() . '/template-parts/blocks/posts.css', array(), _S_VERSION);
	// }

	if (has_block("acf/accordion")) {
		// wp_enqueue_style('accordion_styles', get_template_directory_uri() . '/template-parts/blocks/accordion.css', array(), _S_VERSION);
		wp_enqueue_script(
			"accordion_scripts",
			get_template_directory_uri() .
				"/template-parts/blocks/accordion/accordion.js",
			["jquery"],
			_S_VERSION
		);
	}

	// if (has_block('acf/featured-stories')) {
	//     wp_enqueue_style('featured_stories_styles', get_template_directory_uri() . '/template-parts/blocks/featured-stories.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/carousel')) {
	//     wp_enqueue_style('carousel_styles', get_template_directory_uri() . '/template-parts/blocks/carousel.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/grid-break') && (!is_admin())) {
	//     wp_enqueue_style('grid_break_styles', get_template_directory_uri() . '/template-parts/blocks/grid-break.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/grid-block')) {
	//     wp_enqueue_style('grid_block_styles', get_template_directory_uri() . '/template-parts/blocks/grid-block.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/resources-block')) {
	//     wp_enqueue_style('resources_block_styles', get_template_directory_uri() . '/template-parts/blocks/resources-block.css', array(), _S_VERSION);
	// }

	// if (has_block('acf/careers-block')) {
	//     wp_enqueue_style('careers_block_styles', get_template_directory_uri() . '/template-parts/blocks/careers.css', array(), _S_VERSION);
	// }
}
