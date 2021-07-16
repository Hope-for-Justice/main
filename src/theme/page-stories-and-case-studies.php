<?php
/**
 * Template Name: Stories and Case Studies
 */

get_header();

?>

<main class="stories_case_studies__page">
	<div class="freedom-wall">


		<div class="freedom-wall__image " style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
		<div class="stories_case_title_heading">
			<?php $first_title_str = substr(get_the_title(),0,9);
			$sec_title_str = substr(get_the_title(),14);
			echo $first_title_str.'<span class="case_transparent-title">'.$sec_title_str.'</span>'

			 ?>
		</div>

		
	</div>
	<div class="scs__section">
		<div class="sub-grid">
			<div class="get-involved">

			
			
				<div class="get-involved__text">
					<?php the_content(); ?>
				</div>
		
		


		
	
		
	
		

		<div class="news-page__content">
			
			<?php
		

			// query arguments
		    $args=[
		      'post_type' => 'stories_case_studies',
		      'post_status' => 'publish',
		      'posts_per_page' => -1,

		    
		      ];
		    $query = null;
		    $query = new WP_Query($args);

		 
		    if( $query->have_posts() ) { ?>
		    	
			

		    <!-- posts container-->	
		    <div class="cards sub-grid">

			
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php $title_color = get_field('title_color'); ?>
					<div class="cards__card">
						<a href="<?php the_permalink() ?>" >
							<div class="cards__content" >
								<div class="cards__img-container">
									<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="cards__img">
								</div>
							  	<div class="cards__info">
							    	<div class="cards__text">
										
										<h3 class="scs_cards__title">
											<?php echo '<span style="color:'.$title_color.'">'.get_the_title().'<span>'; ?>	
										</h3>
							    		<p class="cards__excerpt"> <?php echo wp_trim_words( get_the_content(), 18, '' ); ?></p>
							    	</div>
							  	</div>
							</div>
						</a>
					</div>

			    <?php endwhile; wp_reset_postdata(); } ?>

			</div>
			



			<?php wp_reset_query();  ?>

			
</div>
</div>
</div>
</div>
</main>
<?php
get_footer();