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
						<?php the_field('subtitle'); ?>
					</h3>
					<h1 class="font-canela">
						<?php the_title(); ?>
					</h1>
					<div class="hero-split__desc hero-split__desc--thinner">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->
		
		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text careers__vacancies">
			<h2 class="font-canela">
			<?php the_field('vacancies_title'); ?>
			</h2>
			<p>
				<?php the_field('vacancies_description'); ?>
			</p>
		</div><!-- /plain-text -->


		<!-- 
		-- 
		-- career-cards
		-- 
		-->
		<div class="sub-grid career-cards">
				<?php $get_records =  wp_remote_get( 'https://cezanneondemand.intervieweb.it/annunci.php?lang=en&LAC=hopeforjustice&d=hopeforjustice.org&k=1408e0edd8768dfa3e838b0059df4899&CodP=&nbsp;&format=json_en&utype=0');
					// when empty show message
					if (empty($get_records)) {
					echo '<h2 style="text-align: center; grid-column: col2 / col12; opacity:0.5;" class="font-canela">No Vacancies</h2>';
					} 
				?>


					<?php foreach(json_decode($get_records['body']) as $body) { 
					?>
					
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
			<h2 class="font-canela">
				<?php the_field('volunteering_title'); ?>
			</h2>
			<p>
				<?php the_field('volunteering_description'); ?>
			</p>
			<a href="<?php the_field('volunteering_button_link'); ?>" class="button button--red">
				<div class="button__inner">
					<div class="button__text bold">
						<?php the_field('volunteering_button_text'); ?>
					</div>
				</div>
			</a>
		</div><!-- /plain-text -->

		</div><!-- /grid -->

	<?php endwhile ?>

</main><!-- /#main -->

<?php get_footer(); ?>