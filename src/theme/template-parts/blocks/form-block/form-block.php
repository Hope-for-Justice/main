<?php

/**
 * text and form
 *
 */

// Load values and assign defaults.
$margin_bottom_mobile = get_field('margin_bottom_mobile') ?: '40px';
$margin_bottom_desktop = get_field('margin_bottom_desktop') ?: '80px';
?>


<div class="better-grid hfj-block form-block" style="--margin-bottom-mobile:<?php echo $margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $margin_bottom_desktop ?>;">

    <div class="form-block__form">
        <InnerBlocks />
    </div>

</div>