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

//width spacific spanning
$width_spans = get_field('width_spans');
$id = 'block' . uniqid();

?>
<style>
    <?php if (have_rows('width_spans')) {
        while (have_rows('width_spans')) :
            the_row();
            $min_width = get_sub_field('width');
            $col_span = get_sub_field('span'); ?>@media screen and (min-width: <?php echo $min_width ?>px) {
        #<?php echo $id ?> {
            grid-column: span <?php echo $col_span ?>;
        }
    }

    <?php endwhile;
    } ?>
</style>


<!-- grid -->
<div id="<?php echo $id ?>" class="grid-container grid-container--span-<?php echo $span ?> grid-container--align-<?php echo $align ?>" style="padding: <?php echo $padding ?>">
    <?php $template = array(
        array('core/paragraph', array(
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        ))
    );
    echo '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" />';
    ?>
</div>