<?php
/**
 * Template for Email signup /signup
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main signup" role="main">

		<?php while ( have_posts() ) : the_post(); ?>		

		<?php $thumbnail = '';

		// Get the ID of the post_thumbnail (if it exists)
		$post_thumbnail_id = get_post_thumbnail_id($post->ID);

		// if it exists
		if ($post_thumbnail_id) {
			$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
		} ?>

		<div class="grid">
			<!-- 
			-- 
			-- hero
			--  
			-->
			<div style="background-image: url('<?php echo $thumbnail[0]; ?>');" class="signup__hero">
				<div class="sub-grid">
					<header class="signup__header">
						<h1 class="signup__heading font-fk"><?php the_title(); ?>
						</h1>
						<div class="signup__desc">
							<?php the_content(); ?>		
						</div>
					</header>
				</div>
			</div><!-- /hero -->

			<!-- 
			-- 
			-- content
			--  
			-->
			<div class="color-block color-block--grey">
				<div class="sub-grid">
					<div class="signup__content form-page__content">
						<?php the_field('form');?>
					</div>
				</div>
			</div><!-- /content -->

		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>
