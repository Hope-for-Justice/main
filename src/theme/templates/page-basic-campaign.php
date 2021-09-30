<?php
/**
 * Template Name: Basic Campaign
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main campaign" role="main">

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
			-- Hero
			--  
			-->
			<div class="hero">
				<div class="hero__img">
					<img src="<?php echo $thumbnail[0]; ?>">
				</div>
				<div class="sub-grid">
					<div class="hero__info">
						<h1 class="font-fk hero__title">
							<?php the_title(); ?>
						</h1>
						<div class="line line--white line--title"></div>
						<div class="hero__description">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>

		
			<!-- 
			-- 
			-- Inline Giving
			--  
			-->
			<div class="inline-giving">
				<div class="inline-giving__form">
					<?php the_field('giving_form');?>
				</div> 
			</div>

			<div class="inline-giving__info">	
				<h2 class="inline-giving__title font-fk">	
					<?php the_field('form_description_title');?>		
				</h2>
				<div class="inline-giving__description">
					<p>
					<?php the_field('form_description_text');?>
					</p>
				</div>
			</div>

		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>