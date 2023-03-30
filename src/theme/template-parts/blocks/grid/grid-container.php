<?php

/**
 * grid-container
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$span = get_field('span') ?: '6';
$padding = get_field('padding');
$align = get_field('align');

?>


<!-- grid -->
<div class="grid-container grid-container--span-<?php echo $span ?> grid-container--align-<?php echo $align ?>" style="padding: <?php echo $padding ?>">
    <?php $template = array(
        array('core/paragraph', array(
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        ))
    );
    echo '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" />';
    ?>
</div>