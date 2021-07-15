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
			$select_resources_template = get_field('select_resources_template');
			// echo "<pre>";
			// die(print_r($select_resources_template));
			// query arguments
		    $args=array(
		      'post_type' => 'resources_template',
		      'post_status' => 'publish',
		      'posts_per_page' => -1,

		    
		      );
		    $query = null;
		    $query = new WP_Query($args);
		    $resources_template = get_field('select_resources_template');

		    // if have posts show the category title
		    if( $select_resources_template ) { ?>
		    	
			

		    <!-- posts container-->	
		    <div class="cards sub-grid resource__template">

			    <!-- while there is posts display them -->
				 <?php foreach( $resources_template as $rpost ): ?>
					<?php 
					if(get_field('choose_between', $rpost->ID) == 'pdf') {
						$field = get_field('upload_pdf',$rpost->ID); 
					} elseif(get_field('choose_between', $rpost->ID) == 'link') { 
						$field = get_field('link',$rpost->ID); 
					}
					

					?>
					<div class="cards__card ">
						<a href="<?php echo $field; ?>" >
							<div class="cards__content" >
								<div class="cards__img-container">
									<img src="<?php echo get_the_post_thumbnail_url($rpost->ID); ?>" class="cards__img">
								</div>
							  	<div class="cards__info">
							    	<div class="cards__text">
										
										
								    		<span class="cards__excerpt">
								    			<?php echo get_the_excerpt($rpost->ID); ?>
								    		</span>
							    	
							    			
					    				<img src="<?php echo get_template_directory_uri().'/assets/img/download.svg'; ?>" alt="">
							    			
							    		
							    	</div>
							  	</div>
							</div>
						</a>
					</div>

			    <?php endforeach; } ?>

			</div><!-- /posts container-->	

		
	</div>
</div>

</main> <!-- /page container-->



<?php
get_footer();