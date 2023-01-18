<?php

/**
 * accodion-header
 *
 */
?>

<div class="accordion-block__header">
    <?php $template = array(
        array('core/heading', array(
            'content' => '<strong>Accordion title</strong>',
            'level' => 2,
            'className' => 'is-style-apercu has-large-font-size'
        ))
    );
    echo '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" />';
    ?>
    <img alt="arrow" class="accordion-block__arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>">
</div>