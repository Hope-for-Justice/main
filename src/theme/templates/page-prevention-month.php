<?php
/**
 * Template Name: Prevention month
 *
 * @package Hope_for_Justice_2022
 */

get_header(); ?>

<main id="main" class="site-main prevention-month" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

	<?php $thumbnail = '';

	// Get the ID of the post_thumbnail (if it exists)
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);

	// if it exists
	if ($post_thumbnail_id) {
		$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
	} ?>

	<div class="grid">

		
		<div style="background-image: url(<?php echo $thumbnail[0]; ?>);" class="prevention-month__hero-img"></div>

		<h1 class="prevention-month__hero-title font-fk">
			<span>National</span><br>
			<span>slavery &</span><br>
			<span>Human</span><br>
			<span>trafficking</span><br>
			<span>prevention</span><br>
			<span>month</span>
		</h1>


		<h2 class="prevention-month__title font-canela">
			<?php the_field('about_the_month_title')?>
			
		</h2>

		<div class="prevention-month__text">
			<p>
				<?php the_field('about_the_month_text')?>
				
			</p>


			<a href="<?php the_field('button_1_link')?>" class="button button--red">
				<?php the_field('button_1_text')?>
				
			</a>
		</div>

		<div style="background-image: url(<?php the_field('spot_the_signs_image')?>);" class="prevention-month__signs-img"></div>

		<h2 class="prevention-month__title font-canela">
			
			<?php the_field('spot_the_signs_title')?>
		</h2>

		<div class="prevention-month__text">
			<p>
				<?php the_field('spot_the_signs_text')?>
				
			</p>


			<a href="<?php the_field('button_2_link')?>"class="button button--red">
				<?php the_field('button_2_text')?>
				
			</a>
		</div>

		<div style="background-image: url(<?php the_field('social_image')?>);" class="prevention-month__social-img"></div>

		<h2 class="prevention-month__title font-canela">
			<?php the_field('socials_title')?>
			
		</h2>

		<div class="prevention-month__text">
			<p>
				<?php the_field('socials_text')?>
							</p>


			<a href="<?php the_field('button_3_link')?>" class="button button--red">
				<?php the_field('button_3_text')?>
				
			</a>
		</div>



	</div>

	<?php endwhile; // end of the loop. ?>

</main>



<?php get_footer(); ?>















