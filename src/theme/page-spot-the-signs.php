<?php
/**
 * Spot the signs
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main" role="main">

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
		<div class="hero-split hero-split">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content hero-split__content--grey">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						Awareness can save lives
					</h3>
					<h1 class="hero-split__main-heading">
						Spot the Signs<br class="break-from-tablet"> of Modern Slavery
					</h1>
					<p class="hero-split__desc">
						Modern slavery is happening in our communities - being able to spot the signs and know what to do could make a life-changing difference. You might walk past or speak to someone who needs help without you even realising it. Help spread the word about the signs to look out for.  
					</p>
					<div class="hero-spit__button">
						<a href="#" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									Downloadable<br>
									resources
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->


	</div> <!-- /grid -->

	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>