<?php

/**
 * grid inner
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'grid-inner-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}


// Load values and assign defaults.
$width = get_field('width') ?: 'half';
?>

<div id="<?php echo esc_attr($id); ?>" class="grid-inner <?php echo $width ?>">
    <InnerBlocks />
</div>