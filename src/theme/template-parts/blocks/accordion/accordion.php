<?php

if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

$indent = get_field('indent');

?>

<div class="better-grid accordion-block">
    <div class="accordion-block__accordion <?php if ($indent) echo 'accordion-block__accordion--indent' ?>">
        <!-- inner blocks to only allow accordion header and accordion content -->
        <?php $allowed_blocks = array('acf/accordion-header', 'acf/accordion-content');
        echo '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" />';
        ?>
    </div>
</div>