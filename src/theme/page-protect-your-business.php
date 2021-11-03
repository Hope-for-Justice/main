<?php
/**
 * The template for protect your business
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main protect-business">

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
	-- hero split
	-- 
	--> 
	<div class="hero-split">

		<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			<img class="protect-business__sfa" src="<?php echo get_template_directory_uri().'/assets/img/sfa-white.svg'; ?>" alt="">
		</div>

		<div class="hero-split__content">
			<div class="hero-split__content-inner">
				<h3>
					<?php the_field('subtitle'); ?>
				</h3>
				<h1 class="font-canela">
					<?php the_title(); ?>
				</h1>
				<div class="hero-split__desc">
					<?php the_content(); ?>
				</div>
				<div>
					<a href="<?php the_field('link'); ?>" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								<?php the_field('button_text'); ?>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div><!-- /hero-split -->

	</div><!-- .grid -->

	<?php endwhile; // end of the loop. ?>

</main><!-- #main -->

<?php
get_footer();
