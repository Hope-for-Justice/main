<?php
/**
 * Template Name: Resources Template
 */

get_header();

?>

<main class="resources">

	<div class="grid">
		
		<div class="resources__content">	

				<h2 class="resources__title font-canela">
					<!-- Show the title -->
					<?php echo get_the_title(); ?>
				</h2>

				<?php global $post;
				  if ( $post->post_parent ) { ?>
				    <ul class="breadcrumbs">
				    	<li class="breadcrumbs__crumb">
				    		<a class="breadcrumbs__link" href="<?php echo get_permalink( $post->post_parent ); ?>" >
				   			<?php echo get_the_title( $post->post_parent ); ?>
				    		</a>
				    	</li>
				    	<li class="breadcrumbs__seperator">></li>
				    	<li class="breadcrumbs__crumb">
				    		<a class="breadcrumbs__link" href="<?php echo get_permalink( $post ); ?>" >
				   			<?php echo get_the_title( $post ); ?>
				    		</a>
				    	</li>
				    </ul>
				<?php } ?>

				<div class="resources__content">
					<?php echo get_the_content(); ?>
				</div>
		


			
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
		    <div class="cards sub-grid">

			    <!-- while there is posts display them -->
				 <?php foreach( $resources_template as $rpost ): ?>
					
					<?php 
					if(get_field('choose_between', $rpost->ID) == 'pdf') {
						$field = get_field('upload_pdf',$rpost->ID); 
					} elseif(get_field('choose_between', $rpost->ID) == 'link') { 
						$field = get_field('link',$rpost->ID); 
					}
					?>

					<div class="cards__card">
						<a target="_blank" href="<?php echo $field; ?>" download>
							<div class="cards__content" >
								<div class="cards__img-container">
									<img src="<?php echo get_the_post_thumbnail_url($rpost->ID); ?>" class="cards__img">
								</div>
							  	<div class="cards__info">
							    	<div class="cards__text">
							    		<span class="cards__excerpt">
							    			<?php echo get_the_excerpt($rpost->ID); ?>
							    		</span>
							    		<?php if( ! get_field('no_download', $rpost->ID) ) { ?>	
					    				<img class="resources__download" src="<?php echo get_template_directory_uri().'/assets/img/download.svg'; ?>" alt="">
					    				<?php } ?>		
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