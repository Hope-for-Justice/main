<?php
/**
 * The template for /careers
 *
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main careers">

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

			<div class="hero-split__img hero-split__img--top-center " style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content hero-split__content--grey">
				<div class="hero-split__content-inner">
					<h3>
						#TeamHopeforJustice
					</h3>
					<h1 class="font-canela">
						Careers &<br>
						Volunteering
					</h1>
					<p class="hero-split__desc hero-split__desc--thinner">
						Hope for Justice is growing fast and we are always looking for talented and passionate people to join our team. With more than 30 locations across five continents, there are so many ways you can use your skills to make a difference in the fight against modern slavery and human trafficking.
					</p>
				</div>
			</div>
		</div><!-- /hero-split -->
		
		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text">
			<h2 class="font-canela">Current vacancies</h2>
			<p>Hope for Justice is committed to the principles of diversity, equality and inclusion. If you feel that your skills and experience fit one of our roles then we would welcome your application regardless of your background.
			</p>
		</div><!-- /plain-text -->


		<!-- 
		-- 
		-- career-cards
		-- 
		-->
		<div class="sub-grid career-cards">
				<?php $get_records =  wp_remote_get( 'https://cezanneondemand.intervieweb.it/annunci.php?lang=en&LAC=hopeforjustice&d=hopeforjustice.org&k=1408e0edd8768dfa3e838b0059df4899&CodP=&nbsp;&format=json_en&utype=0');
					foreach(json_decode($get_records['body']) as $body) { ?>
					
					<div class="career-cards__card">
						<a class="career-cards__inner" href="<?php echo $body->url; ?>">
							<!-- Card title -->
							<h3 class="career-cards__title font-fk">
								<?php echo $body->title; ?>
							</h3>

							<!-- Arrow -->
							<div class="career-cards__arrow">
								<img src="<?php echo get_template_directory_uri().'/assets/img/arrow.svg'; ?>" />
							</div>

							<!-- location -->
							<div class="career-cards__location">
								<img src="<?php echo get_template_directory_uri().'/assets/img/balloon.svg'; ?>" />
								<p>
									<?php echo $body->location; ?>,&nbsp;<?php echo $body->nation; ?>	
								</p>
							</div>	
						</a>
					</div>	

				<?php } ?>
		</div><!-- /career-cards -->

		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text">
			<h2 class="font-canela">Volunteering opportunities</h2>
			<p><b>Do you want to be part of something incredible? At Hope for Justice, we’re proud to work with a community of amazing volunteers – and we’d love you to join us!</b>
			<br><br>
			Volunteers are the heartbeat of our movement to end slavery. By joining the team at Hope for Justice (wherever you are in the world) you can be part of making huge change happen in virtually every continent. We have been overwhelmed by the kindness of volunteers recently, and are excited to be accepting applications to support our teams, particularly in the following areas:
			</p>
			<a class="button button--red">
				<div class="button__inner">
					<div class="button__text bold">
						See current 
						<br>opportunities
					</div>
				</div>
			</a>
		</div><!-- /plain-text -->

		</div><!-- /grid -->

	<?php endwhile ?>

</main><!-- /#main -->

<?php get_footer(); ?>