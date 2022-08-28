<?php

/**
 * two-col-title-and-text
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'two-col-title-and-text-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}


//block
$block_margin_bottom_mobile = get_field('block_margin_bottom_mobile') ?: '40px';
$block_margin_bottom_desktop = get_field('block_margin_bottom_desktop') ?: '80px';
?>

<div id="<?php echo esc_attr($id); ?>" class="better-grid two-col-title-and-text hfj-block" style="--margin-bottom-mobile:<?php echo $block_margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $block_margin_bottom_desktop ?>;">

    <?php while (have_rows('cols')) : the_row();

        //repeater
        $title = get_sub_field('title') ?: 'Add a title';
        $title_font = get_sub_field('title_font') ?: 'font-canela';
        $title_weight = get_sub_field('title_weight') ?: 'standard';
        $title_margin_bottom_mobile = get_sub_field('title_margin_bottom_mobile') ?: '24px';
        $title_margin_bottom_desktop = get_sub_field('title_margin_bottom_desktop') ?: '24px';
        $title_size = get_sub_field('title_size') ?: 'h3';
        $text = get_sub_field('text') ?: 'Add some text';
        $text_margin_bottom_mobile = get_sub_field('text_margin_bottom_mobile') ?: '24px';
        $text_margin_bottom_desktop = get_sub_field('text_margin_bottom_desktop') ?: '24px';
        $has_button = get_sub_field('has_button') ?: false;
        $link = get_sub_field('link');
        $button_color = get_sub_field('button_color');
        $button_text_color = get_sub_field('button_text_color');
        $button_margin_bottom_mobile = get_sub_field('button_margin_bottom_mobile');
        $button_margin_bottom_desktop = get_sub_field('button_margin_bottom_mobile');

    ?>


        <div class="two-col-title-and-text__col">

            <!-- title -->
            <<?php echo $title_size; ?> style="--margin-bottom-mobile:<?php echo $title_margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $title_margin_bottom_desktop ?>;" class="<?php echo $title_font; ?> block-title">
                <?php if ($title_weight == 'bold') echo '<b>' ?>
                <?php echo $title ?>
                <?php if ($title_weight == 'bold') echo '</b>' ?>
            </<?php echo $title_size; ?>>

            <!-- text -->
            <p class="font-apercu" style="--margin-bottom-mobile:<?php echo $text_margin_bottom_mobile ?>; --margin-bottom-desktop:<?php echo $text_margin_bottom_desktop ?>; ">
                <?php echo $text ?>
            </p>

            <!-- button -->
            <?php if ($has_button) {
                $link_target = $link['target'];
                $link_url = $link['url'];
                $link_text = $link['title'];
            ?>
                <div class="two-col-title-and-text__button" style="--margin-bottom-mobile:<?php echo $button_margin_bottom_mobile ?>; --margin-bottom-desktop:<?php echo $button_margin_bottom_desktop ?>;">
                    <a target="<?php echo $link_target ?>" href="<?php echo $link_url ?>" class="button" style="color:<?php echo $button_text_color ?>; background-color:<?php echo $button_color ?>;">
                        <?php echo $link_text ?>
                    </a>
                </div>
            <?php } ?>

        </div>

    <?php endwhile; ?>

</div>