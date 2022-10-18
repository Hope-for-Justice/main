<?php


add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_style('hope-for-justice-base-styles', get_template_directory_uri() . '/editor-block-base-styles.css', array(), _S_VERSION);
});

//acf block types
add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types()
{
    // Check function exists.
    if (function_exists('acf_register_block_type')) {


        // register full-header-fk-screamer block.
        acf_register_block_type(array(
            'name'              => 'full-header',
            'title'             => __('Full header'),
            'description'       => __('Custom HfJ block. Full header for the top of a page'),
            'render_template'   => 'template-parts/blocks/full-header/full-header.php',
            'category'          => 'hfj-design-system',
            'icon'              => 'cover-image',
            'keywords'          => array('full header', 'header', 'title'),
            'enqueue_assets'    => 'full_header',
        ));

        function full_header()
        {
            wp_enqueue_style('full-header', get_template_directory_uri() . '/template-parts/blocks/full-header.css', array(), _S_VERSION);
        }

        // register text block.
        acf_register_block_type(array(
            'name'              => 'text',
            'title'             => __('Text'),
            'description'       => __('Custom HfJ block. Full width text with max width'),
            'render_template'   => 'template-parts/blocks/text/text.php',
            'category'          => 'hfj-design-system',
            'icon'              => 'text',
            'enqueue_assets'    => 'text_assets',
        ));

        function text_assets()
        {
            wp_enqueue_style('block-text', get_template_directory_uri() . '/template-parts/blocks/block-text.css', array(), _S_VERSION);
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

        function title_assets()
        {
            wp_enqueue_style('title-assets', get_template_directory_uri() . '/template-parts/blocks/block-title.css', array(), _S_VERSION);
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

        function title_and_text_2col_assets()
        {
            wp_enqueue_style('title_and_text_2col_assets', get_template_directory_uri() . '/template-parts/blocks/two-col-title-and-text.css', array(), _S_VERSION);
        }

        //register cards thirds block.
        acf_register_block_type(array(
            'name'              => 'cards-thirds',
            'title'             => __('Cards - Thirds'),
            'description'       => __('Custom HfJ cards. Best to have either 3 or 6 cards.'),
            'render_template'   => 'template-parts/blocks/cards/cards-thirds.php',
            'category'          => 'hfj-design-system',
            'icon'              => 'cover-image',
            'enqueue_assets'    => 'card_third_assets',
        ));

        function card_third_assets()
        {
            wp_enqueue_style('card_third_assets', get_template_directory_uri() . '/template-parts/blocks/cards-thirds.css', array(), _S_VERSION);
        }

        //register big image card block.
        acf_register_block_type(array(
            'name'              => 'big-image-card',
            'title'             => __('Big Image Card'),
            'description'       => __('Custom HfJ card. Big Image Card.'),
            'render_template'   => 'template-parts/blocks/cards/big-image-card.php',
            'category'          => 'hfj-design-system',
            'icon'              => 'cover-image',
            'enqueue_assets'    => 'big_image_card_assets',
        ));

        function big_image_card_assets()
        {
            wp_enqueue_style('big_image_card_assets', get_template_directory_uri() . '/template-parts/blocks/big-image-card.css', array(), _S_VERSION);
        }

        //register button block.
        acf_register_block_type(array(
            'name'              => 'button',
            'title'             => __('Button'),
            'description'       => __('Custom HfJ button.'),
            'render_template'   => 'template-parts/blocks/button/button.php',
            'category'          => 'hfj-design-system',
            'icon'              => 'button',
            'enqueue_assets'    => 'button_assets',
        ));

        function button_assets()
        {
            wp_enqueue_style('button_assets', get_template_directory_uri() . '/template-parts/blocks/button.css', array(), _S_VERSION);
        }

        //register card half block.
        acf_register_block_type(array(
            'name'              => 'cards-half',
            'title'             => __('Cards - Halves'),
            'description'       => __('Custom HfJ cards. Best to have either a multiple of 2.'),
            'render_template'   => 'template-parts/blocks/cards/cards-half.php',
            'category'          => 'hfj-design-system',
            'icon'              => 'cover-image',
            'enqueue_assets'    => 'card_half_assets',
        ));

        function card_half_assets()
        {
            wp_enqueue_style('card_half_assets', get_template_directory_uri() . '/template-parts/blocks/cards-half.css', array(), _S_VERSION);
        }

        //register event header block
        acf_register_block_type(array(
            'name'              => 'event-header',
            'title'             => __('Event - Header'),
            'description'       => __('Use to show the title, time and location of the current event post'),
            'render_template'   => 'template-parts/blocks/event-header/event-header.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'event_header_assets',
        ));

        function event_header_assets()
        {
            wp_enqueue_style('event_header_assets', get_template_directory_uri() . '/template-parts/blocks/event-header.css', array(), _S_VERSION);
        }

        //register event categories block
        acf_register_block_type(array(
            'name'              => 'event-categories',
            'title'             => __('Event - Categories'),
            'description'       => __('Use to show the title, time and location of the current event post'),
            'render_template'   => 'template-parts/blocks/event-categories/event-categories.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'event_header_assets',
        ));

        function event_categories_assets()
        {
            wp_enqueue_style('event_categories_assets', get_template_directory_uri() . '/template-parts/blocks/event-categories.css', array(), _S_VERSION);
        }

        //register event categories block
        acf_register_block_type(array(
            'name'              => 'donate-block',
            'title'             => __('Donate block'),
            'description'       => __('International donate widget'),
            'render_template'   => 'template-parts/blocks/donate-block/donate-block.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'donate_block_assets'
        ));

        function donate_block_assets()
        {
            wp_enqueue_style('donate_block_styles', get_template_directory_uri() . '/template-parts/blocks/donate-block.css', array(), _S_VERSION);

            wp_enqueue_script('donate_block_scripts', get_template_directory_uri() . '/template-parts/blocks/donate-block/donate-block.js', array('jquery'), _S_VERSION);
        }

        //register form block
        acf_register_block_type(array(
            'name'              => 'form-block',
            'title'             => __('Form'),
            'description'       => __('Custom form block. Put a gravity form inside this block'),
            'render_template'   => 'template-parts/blocks/form-block/form-block.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'form_block_assets',
            'supports'          => [
                'jsx'  => true,
            ]
        ));

        function form_block_assets()
        {
            wp_enqueue_style('form_block_styles', get_template_directory_uri() . '/template-parts/blocks/form-block.css', array(), _S_VERSION);
        }

        //register event series block
        acf_register_block_type(array(
            'name'              => 'event-series',
            'title'             => __('Event Series'),
            'description'       => __('Shows upcoming events in a category with an advert for that category'),
            'render_template'   => 'template-parts/blocks/event-series/event-series.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'event_series_assets',
            'supports'          => [
                'jsx'  => true,
            ]
        ));

        function event_series_assets()
        {
            wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
        }

        //register spacer block
        acf_register_block_type(array(
            'name'              => 'hfj-spacer',
            'title'             => __('Spacer'),
            'description'       => __('HfJ responsive spacer'),
            'render_template'   => 'template-parts/blocks/spacer/spacer.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'spacer_assets'
        ));

        function spacer_assets()
        {
            wp_enqueue_style('spacer_assets', get_template_directory_uri() . '/template-parts/blocks/spacer.css', array(), _S_VERSION);
        }

        //register btc event series
        acf_register_block_type(array(
            'name'              => 'btc-event-series',
            'title'             => __('BTC Event series'),
            'description'       => __('Displays BTC events'),
            'render_template'   => 'template-parts/blocks/btc-event-series/btc-event-series.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'btc_event_series_assets'
        ));

        function btc_event_series_assets()
        {
            wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
            wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
        }

        //register events block
        acf_register_block_type(array(
            'name'              => 'events',
            'title'             => __('Events Block'),
            'description'       => __('Displays events'),
            'render_template'   => 'template-parts/blocks/events/events.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'events_assets'
        ));

        function events_assets()
        {
            wp_enqueue_style('events_styles', get_template_directory_uri() . '/template-parts/blocks/events.css', array(), _S_VERSION);
            wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
            wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
        }

        //register btc event series
        acf_register_block_type(array(
            'name'              => 'btc-header',
            'title'             => __('BTC Header'),
            'description'       => __('BTC page header'),
            'render_template'   => 'template-parts/blocks/btc-header/btc-header.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'btc_header_assets'
        ));

        function btc_header_assets()
        {
            wp_enqueue_style('btc_header_styles', get_template_directory_uri() . '/template-parts/blocks/btc-header.css', array(), _S_VERSION);
        }

        //register image and text
        acf_register_block_type(array(
            'name'              => 'image-and-text',
            'title'             => __('Image and Text'),
            'description'       => __('Block for image and text'),
            'render_template'   => 'template-parts/blocks/image-and-text/image-and-text.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'image_text_assets'
        ));

        function image_text_assets()
        {
            wp_enqueue_style('image_text_styles', get_template_directory_uri() . '/template-parts/blocks/image-and-text.css', array(), _S_VERSION);
        }

        //register image
        acf_register_block_type(array(
            'name'              => 'image',
            'title'             => __('Image'),
            'description'       => __('Block for image'),
            'render_template'   => 'template-parts/blocks/image/image.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'image_assets'
        ));

        function image_assets()
        {
            wp_enqueue_style('image_styles', get_template_directory_uri() . '/template-parts/blocks/image.css', array(), _S_VERSION);
        }

        //register dropdown
        acf_register_block_type(array(
            'name'              => 'dropdown',
            'title'             => __('Dropdown'),
            'description'       => __('Block for a dropdown'),
            'render_template'   => 'template-parts/blocks/dropdown/dropdown.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'dropdown_assets'
        ));

        function dropdown_assets()
        {
            wp_enqueue_style('dropdown_styles', get_template_directory_uri() . '/template-parts/blocks/dropdown.css', array(), _S_VERSION);
            wp_enqueue_script('dropdown_scripts', get_template_directory_uri() . '/template-parts/blocks/dropdown/dropdown.js', array('jquery'), _S_VERSION);
        }

        //register social
        acf_register_block_type(array(
            'name'              => 'social',
            'title'             => __('Socials'),
            'description'       => __('Block for a socials'),
            'render_template'   => 'template-parts/blocks/social/social.php',
            'category'          => 'hfj-design-system',
            'enqueue_assets'    => 'social_assets'
        ));

        function social_assets()
        {
            wp_enqueue_style('social_styles', get_template_directory_uri() . '/template-parts/blocks/social.css', array(), _S_VERSION);
        }
    }
}


/**
 * Register the styles (CSS) for the blocks outside
 * acf_register_block_type() as loading styles
 * using acf_register_block_type() will load the
 * styles in the footer and not in <head> causing
 * CLS issues 
 */
add_action('wp_enqueue_scripts', 'register_acf_block_styles');
add_action('admin_enqueue_scripts', 'register_acf_block_styles');

function register_acf_block_styles(): void
{
    //allways enqueue block-title and block text
    wp_enqueue_style('block-text', get_template_directory_uri() . '/template-parts/blocks/block-text.css', array(), _S_VERSION);
    wp_enqueue_style('title-assets', get_template_directory_uri() . '/template-parts/blocks/block-title.css', array(), _S_VERSION);


    if (has_block('acf/full-header')) {
        wp_enqueue_style('full-header', get_template_directory_uri() . '/template-parts/blocks/full-header.css', array(), _S_VERSION);
    }


    if (has_block('acf/two-col-title-and-text')) {
        wp_enqueue_style('title_and_text_2col_assets', get_template_directory_uri() . '/template-parts/blocks/two-col-title-and-text.css', array(), _S_VERSION);
    }

    if (has_block('acf/cards-thirds')) {
        wp_enqueue_style('card_third_assets', get_template_directory_uri() . '/template-parts/blocks/cards-thirds.css', array(), _S_VERSION);
    }

    if (has_block('acf/big-image-card')) {
        wp_enqueue_style('big_image_card_assets', get_template_directory_uri() . '/template-parts/blocks/big-image-card.css', array(), _S_VERSION);
    }

    if (has_block('acf/button')) {
        wp_enqueue_style('button_assets', get_template_directory_uri() . '/template-parts/blocks/button.css', array(), _S_VERSION);
    }

    if (has_block('acf/cards-half')) {
        wp_enqueue_style('card_half_assets', get_template_directory_uri() . '/template-parts/blocks/cards-half.css', array(), _S_VERSION);
    }

    if (has_block('acf/event-header')) {
        wp_enqueue_style('event_header_assets', get_template_directory_uri() . '/template-parts/blocks/event-header.css', array(), _S_VERSION);
    }

    if (has_block('acf/event-categories')) {
        wp_enqueue_style('event_categories_assets', get_template_directory_uri() . '/template-parts/blocks/event-categories.css', array(), _S_VERSION);
    }

    if (has_block('acf/donate-block')) {
        wp_enqueue_style('donate_block_assets', get_template_directory_uri() . '/template-parts/blocks/donate-block.css', array(), _S_VERSION);

        wp_enqueue_script('donate_block_scripts', get_template_directory_uri() . '/template-parts/blocks/donate-block/donate-block.js', array(), _S_VERSION);
    }

    if (has_block('acf/form-block')) {
        wp_enqueue_style('form_block_styles', get_template_directory_uri() . '/template-parts/blocks/form-block.css', array(), _S_VERSION);
    }

    if (has_block('acf/event-series')) {
        wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
    }

    if (has_block('acf/hfj-spacer')) {
        wp_enqueue_style('spacer_assets', get_template_directory_uri() . '/template-parts/blocks/spacer.css', array(), _S_VERSION);
    }

    if (has_block('acf/btc-event-series')) {
        wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
        wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
    }

    if (has_block('acf/events')) {
        wp_enqueue_style('events_styles', get_template_directory_uri() . '/template-parts/blocks/events.css', array(), _S_VERSION);
        wp_enqueue_style('event_series_styles', get_template_directory_uri() . '/template-parts/blocks/event-series.css', array(), _S_VERSION);
        wp_enqueue_style('btc_event_series_assets', get_template_directory_uri() . '/template-parts/blocks/btc-event-series.css', array(), _S_VERSION);
    }

    if (has_block('acf/btc-header')) {
        wp_enqueue_style('events_styles', get_template_directory_uri() . '/template-parts/blocks/btc-header.css', array(), _S_VERSION);
    }

    if (has_block('acf/image-and-text')) {
        wp_enqueue_style('image_text_styles', get_template_directory_uri() . '/template-parts/blocks/image-and-text.css', array(), _S_VERSION);
    }

    if (has_block('acf/image')) {
        wp_enqueue_style('image_styles', get_template_directory_uri() . '/template-parts/blocks/image.css', array(), _S_VERSION);
    }

    if (has_block('acf/dropdown')) {
        wp_enqueue_style('dropdown_styles', get_template_directory_uri() . '/template-parts/blocks/dropdown.css', array(), _S_VERSION);
        wp_enqueue_script('dropdown_scripts', get_template_directory_uri() . '/template-parts/blocks/dropdown/dropdown.js', array('jquery'), _S_VERSION);
    }

    if (has_block('acf/social')) {
        wp_enqueue_style('social_styles', get_template_directory_uri() . '/template-parts/blocks/social.css', array(), _S_VERSION);
    }
}

//register grid block in new way acf 6.0
// function register_test_block() {
//   register_block_type(get_template_directory_uri() . 'template-parts/blocks/block.json');
// }
// add_action('init', 'register_test_block');