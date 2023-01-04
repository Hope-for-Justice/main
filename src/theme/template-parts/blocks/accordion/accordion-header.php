<?php

/**
 * accodion-header
 *
 */
?>

<div class="accordion-block__header">
    <?php $allowed_blocks = array('core/heading', 'core/paragraph');
    echo '<InnerBlocks allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" />';
    ?>
    <img class="accordion-block__arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>">
</div>