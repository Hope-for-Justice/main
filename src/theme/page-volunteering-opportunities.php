<?php
/**
 * Template Name: Volunteering Opportunities
 */

get_header();
?>

<main id="main" class="site-main">

	<div class="container">
		<div class="row">
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

				 		<div class="col-md-6">
						<a href="<?php echo $field; ?>" class="career_card_links">
						<div class="drag-cards career_drag-cards" id="dragCards">
							<div class=" drag-cards__inner_career" >
								<div class="drag-cards__card drag-cards__card_career">

									<h3 class="drag-cards__card-title font-fk"><?php echo get_the_title(); ?></h3>
									<div class="img-icons"><img src="<?php echo get_template_directory_uri().'/assets/img/arrow.svg'; ?>" /></div>
									<p class="drag-cards__card-desc align-items-center"><span class="img-icon">
										<img src="<?php echo get_template_directory_uri().'/assets/img/balloon.svg'; ?>" /></span>
										<span class="card-location"> <?php echo $location; ?>,&nbsp;<?php echo $country; ?></span></p>
								</div>
							</div>
						</div>
						</a>

					</div>
			<?php endwhile; wp_reset_postdata();   } ?>
		</div>
	</div>



</main><!-- /#main -->

<?php get_footer(); ?>