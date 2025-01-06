<?php

/**
 * Other ways to give
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$see_all_link = get_field("see_all_link");

if (!empty($block["className"])) {
	$class_name .= " " . $block["className"];
}
?>


<!-- grid -->
<div class="better-grid grid-block other-ways-to-give <?php echo $class_name; ?>">
    <!-- other ways cards -->
   <div class="better-grid grid-block other-ways-to-give__inner">
   <?php if (have_rows("other_ways_cards")):
   	while (have_rows("other_ways_cards")):

   		the_row();

   		$title = get_sub_field("title");
   		$icon = get_sub_field("icon");
   		$href = get_sub_field("href");
   		?> 

            <a href="<?php echo $href; ?>" class="other-ways-to-give__card">
                <div class="other-ways-to-give__icon">
                    <img src="<?php echo $icon; ?>" alt="icon">
                </div>
                <p class="other-ways-to-give__text">
                    <?php echo $title; ?><span style="white-space: pre;" class="other-ways-to-give__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
	"/assets/img/link-arrow.svg"; ?>"></span>
                </p>
            </a>

        <?php
   	endwhile;
   endif; ?>
   <!-- see all card -->
   <a href="<?php echo $see_all_link; ?>" class="other-ways-to-give__card other-ways-to-give__card--dark">
                <p class="other-ways-to-give__text">
                    See all other ways to give<span style="white-space: pre;" class="other-ways-to-give__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() .
                    	"/assets/img/link-arrow.svg"; ?>"></span>
                </p>
            </a>
   </div>
    

</div>