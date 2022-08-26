<?php

/**
 * cards-half
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'cards-half-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
$count = count(get_field('half_cards'));
$block_margin_bottom_desktop = get_field('block_margin_bottom_desktop') ?: '80px';
$block_margin_bottom_mobile = get_field('block_margin_bottom_mobile') ?: '40px';
?>


<div class="better-grid has-<?php echo $count ?>-cards cards-half hfj-block" style="--margin-bottom-mobile:<?php echo $block_margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $block_margin_bottom_desktop ?>;">


<?php while (have_rows('half_cards')) : the_row(); ?>
    <?php 
    $link_url = get_sub_field('link', ['url']); 
    $link_target = get_sub_field('link', ['target']); 
    ?>
    <a href="<?php echo $link_url ?>" target="<?php echo $link_target ?>" class="block-card">
        <div class="block-card__image-container">
            <?php $image = get_sub_field('image') ?: '309';
            echo wp_get_attachment_image( $image, 'full' ) ?>
        </div>
        <div class="block-card__content">
            <h4 class="block-title block-card__title"><b><?php echo (get_sub_field('title'))?></b></h4>
            <p><?php echo (get_sub_field('text'))?></p>
        </div>
    </a>

<?php endwhile; ?>

</div>