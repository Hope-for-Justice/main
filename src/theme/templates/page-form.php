<?php

/**
 * Template Name: Form page
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


<main id="main" class="site-main form-page" role="main">

	<?php while (have_posts()) : the_post(); ?>

		<div class="full-grid">
			<!-- 
			-- 
			-- content
			--  
			-->
			<div class="form-page__content">
				<?php
				if (
					$GLOBALS['userInfo']
					&& in_array($GLOBALS['userInfo'], $GLOBALS['usa'])
				) {
					//US
					echo do_shortcode(get_field('us_form'));
				} else if (
					$GLOBALS['userInfo']
					&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])
				) {
					//Norway
					echo do_shortcode(get_field('norway_form'));
				} else if (
					$GLOBALS['userInfo']
					&& in_array($GLOBALS['userInfo'], $GLOBALS['aus'])
				) {
					//AUS
					echo do_shortcode(get_field('aus_form'));
				} else {
					//UK fallback
					echo do_shortcode(get_field('uk_form'));
				} ?>
			</div>
		</div><!-- /grid -->

	<?php endwhile; // end of the loop. 
	?>

</main><!-- #main -->

<?php get_footer(); ?>