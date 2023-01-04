<?php

/**
 * accodion-content
 *
 */
?>

<div class="accordion-block__content">
    <?php $allowed_blocks = array('core/heading', 'core/paragraph', 'core/list');
    echo '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" />';
    ?>
</div> -->