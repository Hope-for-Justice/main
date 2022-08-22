<?php

/**
 * text
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'block-text-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
// $className = 'block-full-header-fk';
// if( !empty($block['className']) ) {
//     $className .= ' ' . $block['className'];
// }
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// Load values and assign defaults.
$text = get_field('text') ?: 'Add some text';
?>


<div id="<?php echo esc_attr($id); ?>" class="better-grid">
    <p style="" class="block-text">
        <?php echo $text ?>
    </p>
</div>
