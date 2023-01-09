<?php

if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

$indent = get_field('indent');
$open = get_field('open');

?>

<div class="better-grid accordion-block <?php if (is_admin() && $open) echo 'accordion-block--open' ?>">
    <div class="accordion-block__accordion <?php if ($indent) echo 'accordion-block__accordion--indent' ?>">
        <!-- inner blocks to only allow accordion header and accordion content -->
        <?php $template = array(
            array('acf/accordion-header'),
            array('acf/accordion-content')
        );
        $allowed_blocks = array('acf/accordion-content');
        echo '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" />';
        ?>
    </div>
</div>