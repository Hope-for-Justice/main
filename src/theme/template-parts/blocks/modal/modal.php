<?php

/**
 * modal block
 *
 */

$name = get_field('modal_name');

?>
<?php if (is_admin()) echo '<p style="background:red; color:white; display:inline-block;">Modal content:</p>' ?>
<div <?php if (!is_admin()) { ?> class="modal fade" <?php } ?> id="<?php echo $name ?>" tabindex="-1" role="dialog" aria-hidden="false">
    <div <?php if (!is_admin()) { ?>class="modal__dialog" <?php } ?>>
        <div <?php if (!is_admin()) { ?> class="modal__content modal__content--block" <?php } ?>>
            <?php $template = array(
                array('core/paragraph', array(
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                ))
            );
            echo '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" />';
            ?>
            <?php if (!is_admin()) { ?><a href="#" data-dismiss="modal" class="gi-close modal__close">&times;<span class="accessibility">Close</span></a><?php } ?>
        </div>
    </div>
</div>