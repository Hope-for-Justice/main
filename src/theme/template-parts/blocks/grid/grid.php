<?php

/**
 * grid-block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$indent = get_field('indent');
$row_space = get_field('row_space') ?: 'large';

if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

?>


<!-- grid -->
<div class="better-grid grid-block <?php echo $class_name ?>">
    <!-- inner grid -->
    <div class="better-grid grid-block__inner grid-block__inner--row-space-<?php echo $row_space ?> <?php if ($indent) echo 'grid-block__inner--indent' ?>">
        <!-- inner blocks to only allow grid-content -->
        <?php $template = array(
            array('acf/grid-container'),
            array('acf/grid-container')
        );
        $allowed_blocks = array('acf/grid-container');
        echo '<InnerBlocks useInnerBlocksProps template="' . esc_attr(wp_json_encode($template)) . '" allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" />';
        ?>
    </div>
</div>