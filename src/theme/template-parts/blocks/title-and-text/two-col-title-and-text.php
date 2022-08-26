<?php

/**
 * two-col-title-and-text
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'two-col-title-and-text-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Load values and assign defaults.

//a
$title_a = get_field('title_a') ?: 'Add a title (A)';
$title_a_font = get_field('title_a_font') ?: 'font-canela';
$margin_bottom_a_mobile = get_field('margin_bottom_a_mobile') ?: '24px';
$margin_bottom_a_desktop = get_field('margin_bottom_a_desktop') ?: '24px';
$size_a = get_field('size_a') ?: 'h3';
$text_a = get_field('text_a') ?: 'Add some text (A)';
$text_margin_bottom_a_mobile = get_field('margin_bottom_b_mobile') ?: '24px';
$text_margin_bottom_a_desktop = get_field('margin_bottom_b_desktop') ?: '24px';
$a_has_button = get_field('b_has_button') ?: false;
$a_link = get_field('a_link');
$a_button_color = get_field('a_button_color');
$a_button_text_color = get_field('a_button_text_color');

//b
$title_b = get_field('title_b') ?: 'Add a title (B)';
$title_b_font = get_field('title_b_font') ?: 'font-canela';
$margin_bottom_b_mobile = get_field('margin_bottom_b_mobile') ?: '24px';
$margin_bottom_b_desktop = get_field('margin_bottom_b_desktop') ?: '24px';
$size_b = get_field('size_b') ?: 'h3';
$text_b = get_field('text_b') ?: 'Add some text (B)';
$text_margin_bottom_b_mobile = get_field('margin_bottom_b_mobile') ?: '24px';
$text_margin_bottom_b_desktop = get_field('margin_bottom_b_desktop') ?: '24px';
$b_has_button = get_field('b_has_button') ?: false;
$b_link = get_field('b_link');
$b_button_color = get_field('a_button_color');
$b_button_text_color = get_field('a_button_text_color');

//block
$block_margin_bottom_mobile = get_field('block_margin_bottom_mobile') ?: '40px';
$block_margin_bottom_desktop = get_field('block_margin_bottom_desktop') ?: '80px';
?>

<div id="<?php echo esc_attr($id); ?>" class="better-grid two-col-title-and-text hfj-block" style="--margin-bottom-mobile:<?php echo $block_margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $block_margin_bottom_desktop ?>;">
    <div class="two-col-title-and-text__col-a">
       <!-- a title -->
        <<?php echo $size_a; ?> style="--margin-bottom-mobile:<?php echo $margin_bottom_a_mobile ?>; --margin-bottom-desktop: <?php echo $margin_bottom_a_desktop ?>;"
        class="<?php echo $title_a_font; ?> block-title">
            <?php echo $title_a ?><!-- a title text -->
        </<?php echo $size_a; ?>>
        <!-- a text -->
        <p class="font-apercu" style="--margin-bottom-mobile:<?php echo $text_margin_bottom_a_mobile ?>; --margin-bottom-desktop:<?php echo $text_margin_bottom_a_desktop ?>; ">
            <?php echo $text_a ?>
        </p>
        <!-- a button -->
        <?php if ($a_has_button) {
            $link_target_a = $a_link['target'];
            $link_url_a = $a_link['url'];
            $link_text_a = $a_link['text'];
            ?>
            <div class="two-col-title-and-text__button">
                <a target="<?php echo $link_target_a ?>" href="<?php echo $link_url_a ?>" 
                class="button">
                    <?php echo $link_text_a ?>
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="two-col-title-and-text__col-b">

        <<?php echo $size_b; ?> style="--margin-bottom-mobile:<?php echo $margin_bottom_b_mobile ?>; --margin-bottom-desktop: <?php echo $margin_bottom_b_desktop ?>;"
        class="<?php echo $title_b_font; ?> block-title">
            <?php echo $title_b ?>
        </<?php echo $size_b; ?>>

        <p class="font-apercu" 
        style="--margin-bottom-mobile:<?php echo $text_margin_bottom_b_mobile ?>; --margin-bottom-desktop:<?php echo $text_margin_bottom_b_desktop ?>; ">
            <?php echo $text_b ?>
        </p>

        <?php if ($b_has_button) {
            $link_target_b = $b_link['target'];
            $link_url_b = $b_link['url'];
            $link_text_b = $b_link['text'];
            ?>
            <div class="two-col-title-and-text__button">
                <a target="<?php echo $link_target_b ?>" href="<?php echo $link_url_b ?>" class="button"><?php echo $link_text_b ?></a>
            </div>                   
        <?php } ?>
    </div>
</div>
