<?php

/**
 * accodion-header
 *
 */
?>

<div class="accordion-block__content">
    <?php $template = array(
        array('core/paragraph', array(
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        ))
    );
    $allowed_blocks = array('core/heading', 'core/paragraph', 'core/list', 'core/spacer');
    echo '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" />';
    ?>
</div>