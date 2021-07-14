<?php
/**
 * Template Name: Resources Template
 */

get_header();

?>

<main class="news-page" id="news-page">

	<div class="grid">
		
		<div class="news-page__content resource-container">
			<!-- Header and social icons -->	
			

				<h1 class="resource-header__title  ">
					<!-- Show the title -->
					<?php echo get_the_title(); ?>
				</h1>

				

		


			
			<?php

			// query arguments
		    $args=array(
		      'post_type' => 'resources_template',
		      'post_status' => 'publish',
		      'posts_per_page' => -1,

		    
		      );
		    $query = null;
		    $query = new WP_Query($args);

		    // if have posts show the category title
		    if( $query->have_posts() ) { ?>
		    	
			

		    <!-- posts container-->	
		    <div class="cards sub-grid resource__template">

			    <!-- while there is posts display them -->
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php 
					if(get_field('choose_between') == 'pdf') {
						$field = get_field('upload_pdf',$query->ID); 
					} elseif(get_field('choose_between') == 'link') { 
						$field = get_field('link',$query->ID); 
					}
					

					?>
					<div class="cards__card ">
						<a href="<?php echo $field; ?>" >
							<div class="cards__content" >
								<div class="cards__img-container">
									<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="cards__img">
								</div>
							  	<div class="cards__info">
							    	<div class="cards__text">
										
										
								    		<span class="cards__excerpt">
								    			<?php echo get_the_excerpt(); ?>
								    		</span>
							    	
							    			
					    				<img src="<?php echo get_template_directory_uri().'/assets/img/download.svg'; ?>" alt="">
							    			
							    		
							    	</div>
							  	</div>
							</div>
						</a>
					</div>

			    <?php endwhile; wp_reset_postdata(); } ?>

			</div><!-- /posts container-->	

		
	</div>
</div>

</main> <!-- /page container-->



<?php
get_footer();