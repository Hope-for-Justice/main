<?php
/**
 * Template Name: Form with picture
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main form-picture" role="main">

		<?php while ( have_posts() ) : the_post(); ?>		

		<?php $thumbnail = '';

		// Get the ID of the post_thumbnail (if it exists)
		$post_thumbnail_id = get_post_thumbnail_id($post->ID);

		// if it exists
		if ($post_thumbnail_id) {
			$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
		} ?>

		<div class="full-grid">

			<!-- hero -->
			<div style="background-image: url('<?php echo $thumbnail[0]; ?>');" class="form-picture-hero"></div>

			<!-- title -->
			<div class="form-picture-title">
				<h1 class="form-picture-title font-fk"><?php the_title(); ?></h1>
			</div>

			<!-- content -->
			<div class="form-picture-form">
				<div class="form-picture-form__inner">		
				<?php 
					if($GLOBALS['userInfo'] 
					&& in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ 
						//US
						echo do_shortcode( get_field('us_form') );
					} 
					else if($GLOBALS['userInfo'] 
					&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { 
						//Norway
						echo do_shortcode( get_field('norway_form') );
					}
					else if($GLOBALS['userInfo'] 
					&& in_array($GLOBALS['userInfo'], $GLOBALS['aus'])) {
						//AUS
						echo do_shortcode( get_field('aus_form') );
					}
					else {
						//UK fallback
						echo do_shortcode( get_field('uk_form') );
				} ?>
				</div>
			</div><!-- /content -->

		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>