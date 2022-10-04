<?php

/**
 * big-image-card
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Load values and assign defaults.
$title = get_field('title') ?: 'Add a title';
$text = get_field('text') ?: 'Add some text';
$text_margin_bottom = get_field('text_margin_bottom') ?: '24px';
$link = get_field('link');
if ($link) {
    $link_url = $link['url'] ?: '#';
    $link_title = $link['title'] ?: 'Button text';
    $link_target = $link['target'] ? $link['target'] : '_self';
}

$image = get_field('image') ?: '309';
$gradient_a = get_field('gradient_a');
$gradient_b = get_field('gradient_b');
$title_size = get_field('title_size') ?: 'big-image-card__title--large';
$title_font = get_field('title_font') ?: 'font-fk';
$title_font_weight = get_field('title_font_weight') ?: 'regular';
$title_margin_bottom = get_field('title_margin_bottom') ?: '16px';
$date = get_field('date');
$date_mod = date("M j", strtotime($date));
//$button_text = get_field('button_text') ?: 'Button text';

$block_margin_bottom_desktop = get_field('block_margin_bottom_desktop') ?: '80px';
$block_margin_bottom_mobile = get_field('block_margin_bottom_mobile') ?: '40px';
?>


<div class="better-grid hfj-block big-image-card-parent" style="--margin-bottom-mobile:<?php echo $block_margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $block_margin_bottom_desktop ?>;">
    <div class="big-image-card" style="background:<?php echo $gradient_a ?>">

        <?php echo wp_get_attachment_image($image, 'full') ?>

        <div class="big-image-card__gradient big-image-card__gradient--desktop" style="background: linear-gradient(90deg, <?php echo $gradient_a ?> 0%, <?php echo $gradient_b ?> 100%);">
        </div>

        <div class="big-image-card__gradient big-image-card__gradient--mobile" style="background: linear-gradient(180deg, <?php echo $gradient_a ?> 0%, <?php echo $gradient_b ?> 100%);">
        </div>

        <div class="big-image-card__content">
            <?php if ($date) { ?>
                <div class="big-image-card__date">
                    <svg id="Group_7762" data-name="Group 7762" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.819 11.82">
                        <path id="Path_17202" data-name="Path 17202" d="M5.91,11.819a5.91,5.91,0,1,1,5.91-5.91,5.916,5.916,0,0,1-5.91,5.91M5.91.985A4.925,4.925,0,1,0,10.834,5.91,4.93,4.93,0,0,0,5.91.985" transform="translate(0 0)" fill="#ffffff" />
                        <path id="Path_17203" data-name="Path 17203" d="M7.04,7.109H6.969a.4.4,0,0,1-.4-.4V3.567a.4.4,0,0,1,.4-.4H7.04a.4.4,0,0,1,.4.4V6.711a.4.4,0,0,1-.4.4" transform="translate(-1.095 -0.528)" fill="#ffffff" />
                        <path id="Path_17204" data-name="Path 17204" d="M6.569,7.237l.089-.1a.367.367,0,0,1,.519-.021L8.949,8.754a.367.367,0,0,1,.021.518l-.091.1a.365.365,0,0,1-.517.021L6.589,7.755a.366.366,0,0,1-.02-.518" transform="translate(-1.078 -1.17)" fill="#ffffff" />
                    </svg>
                    <p><?php echo $date_mod ?></p>
                </div>
            <?php } ?>

            <<?php if ($title_size == 'big-image-card__title--large') {
                    echo 'h1';
                } else {
                    echo $title_size;
                } ?> style="margin-bottom:<?php echo $title_margin_bottom ?>" class="<?php if ($title_size == 'big-image-card__title--large') echo $title_size ?> big-image-card__title block-title <?php echo $title_font ?>">
                <?php echo $title ?>
            </<?php if ($title_size == 'big-image-card__title--large') {
                    echo 'h1';
                } else {
                    echo $title_size;
                } ?>>
            <p style="margin-bottom:<?php echo $text_margin_bottom ?>" class="big-image-card__text font-apercu">
                <?php if ($title_font_weight == 'bold') echo '<b>' ?>
                <?php echo $text ?>
                <?php if ($title_font_weight == 'bold') echo '</b>' ?>
            </p>
            <div><a target="<?php echo $link_target ?>" href="<?php echo $link_url ?>" class="button"><?php echo $link_title ?></a></div>
        </div>

    </div>
</div>