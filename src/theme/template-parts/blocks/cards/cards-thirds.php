<?php

/**
 * card-thirds
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'title-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
//$title = get_field('title') ?: 'Add a title';
//$text = get_field('margin_bottom') ?: '24px';
// $size = get_field('size') ?: 'h3';
// $width = get_field('width') ?: 'block-title--full';


//count the cards initially
//$i=1; while (have_rows('drop_cards')) : the_row(); $i++; endwhile; 
$count = get_field('third_cards');
?>


<div class="better-grid has-<?php echo $count ?>-cards">


<?php while (have_rows('third_cards')) : the_row(); ?>

    <div class="block-card">
        <div class="block-card__image-container">
            <?php $image = get_sub_field('image');
            echo wp_get_attachment_image( $image, 'full' ) ?>
        </div>
        <div class="block-card__content">
            <h4 class="block-title block-card__title"><b><?php echo (get_sub_field('title'))?></b></h4>
            <p><?php echo (get_sub_field('text'))?></p>
        </div>
    </div>

<?php endwhile; ?>

</div>