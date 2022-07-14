<?php

get_header();

?>

<main class="resources">

	<div class="grid">
		
		<div class="resources__content">

            <ul class="breadcrumbs">
                <li class="breadcrumbs__crumb">
                    <a class="breadcrumbs__link" href="/resources-and-statistics/" >
                    Resources
                    </a>
                </li>
                <li class="breadcrumbs__seperator">></li>
                <li class="breadcrumbs__crumb">
                    <div class="breadcrumbs__link">
                    <?php echo get_the_title(); ?>
                    </div>
                </li>
            </ul>
					    	

		    <!-- posts container-->	
		    <div class="cards sub-grid">

			    <!-- while there is posts display them -->
					
					<?php 
					if(get_field('choose_between') == 'pdf') {
						$field = get_field('upload_pdf'); 
					} elseif(get_field('choose_between') == 'link') { 
						$field = get_field('link'); 
					}
					?>

					<div class="cards__card">
						<a target="_blank" href="<?php echo $field; ?>" download>
							<div class="cards__content" >
								<div class="cards__img-container">
									<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="cards__img">
								</div>
							  	<div class="cards__info">
							    	<div class="cards__text">
							    		<span class="cards__excerpt">
							    			<?php echo get_the_excerpt(); ?>
							    		</span>
							    		<?php if( ! get_field('no_download') ) { ?>	
					    				<img class="resources__download" src="<?php echo get_template_directory_uri().'/assets/img/download.svg'; ?>" alt="">
					    				<?php } ?>		
							    	</div>
							  	</div>
							</div>
						</a>
					</div>

			</div><!-- /posts container-->	

		
	</div>
</div>

</main> <!-- /page container-->



<?php
get_footer();