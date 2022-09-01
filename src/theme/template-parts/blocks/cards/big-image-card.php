<?php

/**
 * big-image-card
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'big-image-card-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
$title = get_field('title') ?: 'Add a title';
$text = get_field('text') ?: 'Add some text';
$text_margin_bottom = get_field('text_margin_bottom') ?: '24px';
$link = get_field('link');
$image = get_field('image') ?: '309';
$gradient_a = get_field('gradient_a');
$gradient_b = get_field('gradient_b');
$title_size = get_field('title_size') ?: 'big-image-card__title--large';
$title_font = get_field('title_font') ?: 'font-fk';
$title_font_weight = get_field('title_font_weight') ?: 'regular';
$title_margin_bottom = get_field('title_margin_bottom') ?: '16px';
//$button_text = get_field('button_text') ?: 'Button text';

$block_margin_bottom_desktop = get_field('block_margin_bottom_desktop') ?: '80px';
$block_margin_bottom_mobile = get_field('block_margin_bottom_mobile') ?: '40px';
?>


<div id="<?php esc_attr($id)?>" class="better-grid hfj-block big-image-card-parent" style="--margin-bottom-mobile:<?php echo $block_margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $block_margin_bottom_desktop ?>;">
    <div class="big-image-card" style="background:<?php echo $gradient_a ?>">

        <?php echo wp_get_attachment_image( $image, 'full' ) ?>

        <div class="big-image-card__gradient big-image-card__gradient--desktop"
            style="background: linear-gradient(90deg, <?php echo $gradient_a ?> 0%, <?php echo $gradient_b ?> 100%);">
        </div>

        <div class="big-image-card__gradient big-image-card__gradient--mobile"
            style="background: linear-gradient(180deg, <?php echo $gradient_a ?> 0%, <?php echo $gradient_b ?> 100%);">
        </div>

        <div class="big-image-card__content">
            <<?php if($title_size == 'big-image-card__title--large'){
                    echo 'h1';
                } 
                else{
                    echo $title_size;
                }?> 
            style="margin-bottom:<?php echo $title_margin_bottom?>" 
            class="<?php if($title_size == 'big-image-card__title--large')echo $title_size ?> big-image-card__title <?php echo $title_font?>"> 
                <?php echo $title ?> 
            </<?php if($title_size == 'big-image-card__title--large'){
                echo 'h1';
                }
                else{
                    echo $title_size;
                }?>>
            <p style="margin-bottom:<?php echo $text_margin_bottom?>" class="big-image-card__text font-apercu">
                <?php if($title_font_weight == 'bold') echo '<b>'?>
                <?php echo $text ?>
                <?php if($title_font_weight == 'bold') echo '</b>'?>
            </p>
            <?php
            $link_url = $link['url'];
            $link_title = $link['title'] ?: 'Button text';
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <div><a target="<?php echo $link_target ?>" href="<?php echo $link_url ?>" class="button"><?php echo $link_title ?></a></div>
        </div>

    </div>
</div>