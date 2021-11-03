<?php
/**
 * Template Name: Volunteering Opportunities
 */

get_header();
?>

<main id="main" class="site-main careers volunteering">

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

			<div class="hero-split__img hero-split__img--center-center " style="background-image: url('<?php echo $thumbnail[0]; ?>');">
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
		<div class="plain-text">
			<h2 class="font-canela">
				<?php the_field('plain_text_title'); ?>
			</h2>
			<p>
				<?php the_field('plain_text_description'); ?>
			</p>
		</div><!-- /plain-text -->


		<!-- 
		-- 
		-- career-cards
		-- 
		-->
		<div class="sub-grid career-cards">
				<?php
				$args=array(
				'post_type' => 'vol_opp',
				'post_status' => 'publish',
				'posts_per_page' => -1,


				);
				$query = null;
				$query = new WP_Query($args);
				if( $query->have_posts() ) { 
				 	while ($query->have_posts()) : $query->the_post(); ?>
				 		<?php 
				 		if(get_field('choose_between') == 'pdf') {
				 			$field = get_field('upload_pdf',$query->ID); 
				 		} elseif(get_field('choose_between') == 'link') { 
				 			$field = get_field('link',$query->ID); 
				 		} 
				 		$location = get_field('location',$query->ID); 
				 		$country = get_field('country',$query->ID); 
				 		?>
					
					<div class="career-cards__card">
						<a class="career-cards__inner" href="<?php echo $field; ?>">
							<!-- Card title -->
							<h3 class="career-cards__title font-fk">
								<?php echo get_the_title(); ?>
							</h3>

							<!-- Arrow -->
							<div class="career-cards__arrow">
								<img src="<?php echo get_template_directory_uri().'/assets/img/arrow.svg'; ?>" />
							</div>

							<!-- location -->
							<div class="career-cards__location">
								<img src="<?php echo get_template_directory_uri().'/assets/img/balloon.svg'; ?>" />
								<p>
									<?php echo $location; ?>,&nbsp;<?php echo $country; ?>	
								</p>
							</div>	
						</a>
					</div>	

				<?php endwhile; wp_reset_postdata();   } ?>
		</div><!-- /career-cards -->


		</div><!-- /grid -->

	<?php endwhile ?>

</main><!-- /#main -->

<?php get_footer(); ?>