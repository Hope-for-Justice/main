<?php
/**
 * Template Name: News Categories
 */

get_header();

?>

<main class="news-page" id="news-page">

	<div class="grid news-page__grid">

		<div class="news-page__content">
			<!-- Header and social icons -->	
			<div class="news-header">

				<h1 class="news-header__title font-fk">
					<!-- Show the title -->
					<?php echo strtoupper(get_the_title()); ?>
				</h1>

				<div class="news-header__links">
					<!-- Contact press -->
					<p class="news-header__press">
						<span class="bold">Contact Press: </span><a href="mailto:press@hopeforjustice.org">press@hopeforjustice.org</a>
					</p>
					<!-- social icons -->
					<ul class="footer__social-icons">
						<li class="footer__social-icon">
							<a href="<?php echo the_field('linked_in_link', 'option'); ?>" target="_blank">
								<img src="<?php echo get_template_directory_uri().'/assets/img/li-red.svg'; ?>" alt="">
							</a>
						</li>
						<li class="footer__social-icon">
							<a href="<?php echo the_field('instagram_link', 'option'); ?>" target="_blank">
								<img src="<?php echo get_template_directory_uri().'/assets/img/in-red.svg'; ?>" alt="">
							</a>
						</li>
						<li class="footer__social-icon">
							<a href="<?php echo the_field('twitter_link', 'option'); ?>" target="_blank">
								<img src="<?php echo get_template_directory_uri().'/assets/img/tw-red.svg'; ?>" alt="">
							</a>
						</li>
						<li class="footer__social-icon">
							<a href="<?php echo the_field('facebook_link', 'option'); ?>" target="_blank">
								<img src="<?php echo get_template_directory_uri().'/assets/img/fb-red.svg'; ?>" alt="">
							</a>
						</li>
					</ul>
					<div class="line"></div>
				</div>

			</div>


			<!-- 
			--
			-- Top News
			--
			-->

			<!-- Get category -->
			<?php
			$top_category = get_category(4);

			// query arguments
		    $args=array(
		      "cat" => $top_category->term_id,
		      'post_type' => 'post',
		      'post_status' => 'publish',
		      'posts_per_page' => 9,

		    
		      );
		    $query = null;
		    $query = new WP_Query($args);

		    // if have posts show the category title
		    if( $query->have_posts() ) { ?>
		    	
			<h2 class="news-page__title font-canela">
				<?php echo $top_category->name; ?>
			</h2>

		    <!-- posts container-->	
		    <div class="cards sub-grid" id="term_slug_<?php echo $top_category->term_id; ?>">

			    <!-- while there is posts display them -->
				<?php while ($query->have_posts()) : $query->the_post(); ?>

					<div class="cards__card category_<?php echo $top_category->term_id; ?>" >
						<a href="<?php the_permalink() ?>" >
							<div class="cards__content" >
								<div class="cards__img-container">
									<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="cards__img">
								</div>
							  	<div class="cards__info">
							    	<div class="cards__text">
										<p class="cards__date">
											<?php echo get_the_date(); ?>
										</p>
										<h3 class="cards__title threeLines font-canela">
											<?php the_title(); ?>	
										</h3>
							    		<p class="cards__excerpt">
							    			<?php echo get_the_excerpt(); ?>
							    		</p>
							    	</div>
							  	</div>
							</div>
						</a>
					</div>

			    <?php endwhile; wp_reset_postdata(); } ?>

			</div><!-- /posts container-->	

			<!-- see more posts button -->
	    	<div class="news-page__button">
				<a href="javascript:void(0)" class="button button--white more_posts" data-term="<?php echo $top_category->term_id; ?>" data-href="<?php echo home_url().'/news/category/top_news/';?>">
					<div class="button__inner">
						<div class="button__text bold">See more</div>
					</div>
				</a>
	    	</div>


			<!-- 
			--
			-- Videos
			--
			-->

			<?php wp_reset_query();  // Restore global post data stomped by the_post().?>

			<!-- Get category -->
			<?php $video_category = get_category(5);

			// query arguments
		    $args=array(
		      "cat" => $video_category->term_id,
		      'post_type' => 'post',
		      'post_status' => 'publish',
		      'posts_per_page' => 9,
		    );

		    $query = null;
		    $query = new WP_Query($args);

		    // if there is posts show the title
		    if( $query->have_posts() ) { ?>
		    	
			<h2 class="news-page__title font-canela" >
				<?php echo $video_category->name; ?>
			</h2>
		    	
		    <!-- posts container-->	
		    <div class="cards sub-grid" id="term_slug_<?php echo $video_category->term_id; ?>">
		    
			    <!-- While there are posts show them -->
				<?php while ($query->have_posts()) : $query->the_post(); ?>
				<!-- variables -->
				<?php 
					$iframe = get_field('upload_video',false, false);
					$vimeo = explode('/',$iframe);
					$viemo_id = end($vimeo);
				?>

				<div class="cards__card category_<?php echo $video_category->term_id; ?>" >
					<a class="video-trigger" data-src="https://player.vimeo.com/video/<?php echo @$viemo_id;?>" data-toggle="modal" data-target="#video-modal">
						<div class="cards__content">
							<div class="cards__img-container">
								<img class="cards__play-symbol" src="<?php echo get_template_directory_uri() . '/assets/img/play.svg'; ?>">
							  	<img class="cards__img" src="<?php echo get_the_post_thumbnail_url(); ?>">
						  	</div>
						
						  	<div class="cards__info">
						    	<div class="cards__text">
									<p class="cards__date">
										<?php echo get_the_date(); ?>
									</p>
									<h3 class="cards__title threeLines font-canela">
										<span class="no-links"><?php the_title(); ?></span>
									</h3>
							    	<p class="cards__excerpt">
							    		<?php echo get_the_excerpt(); ?>
							    	</p>
						    	</div>
							</div>
						</div>
					</a>
				</div>
			      
			    <?php endwhile; wp_reset_postdata(); } ?>
			
			</div><!-- /posts container-->	

			<!-- see more posts button -->	
	    	<div class="news-page__button">
				<a href="javascript:void(0)" class="button button--white more_posts" data-term="<?php echo $video_category->term_id; ?>" data-href="<?php echo home_url().'/news/category/videos/';?>">
					<div class="button__inner">
						<div class="button__text bold">See more</div>
					</div>
				</a>
	    	</div>

	    	<!-- 
			--
			-- Blogs & editorial
			--
			-->

			<?php wp_reset_query();  // Restore global post data stomped by the_post().?>
			
			<!-- Get category -->
			<?php $blog_category = get_category(7);

			// query arguments
		    $args=array(
		      "cat" => $blog_category->term_id,
		      'post_type' => 'post',
		      'post_status' => 'publish',
		      'posts_per_page' => 9,
		    );

		    $query = null;
		    $query = new WP_Query($args);

		    // if there is posts show the title
		    if( $query->have_posts() ) { ?>
		    	
			<h2 class="font-canela news-page__title" >
				<?php echo $blog_category->name; ?>
			</h2>

		    <!-- posts container-->
		    <div class="cards sub-grid" id="term_slug_<?php echo $blog_category->term_id; ?>">
				
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					
					<a href="<?php the_permalink() ?>" class="cards__card cards__card--blog category_<?php echo $blog_category->term_id; ?>" >	
						<div class="cards__content cards__content--blog" >
							<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="cards__img cards__img--blog">
							<div class="cards__info cards__info--blog">
								<div class=""> 
									<h3 class="cards__title cards__title--blog font-fk">
										<?php the_title(); ?>
									</h3>
									<p class="cards__date cards__date--blog">
										<?php echo get_the_date(); ?>
									</p>
								</div>
							</div>
						</div>	
					</a>

		       <?php endwhile; wp_reset_postdata(); } ?>

			</div><!-- /posts container-->

			<!-- see more posts button -->	
	    	<div class="news-page__button">
				<a href="javascript:void(0)" class="button button--white more_posts" data-term="<?php echo $headline_category->term_id; ?>" data-href="<?php echo home_url().'/news/category/blogs_and_opinion_editorials/';?>">
					<div class="button__inner">
						<div class="button__text bold">See more</div>
					</div>
				</a>
	    	</div>


			<?php wp_reset_query();  // Restore global post data stomped by the_post().?>


			<!-- 
			--
			-- In the headlines
			--
			-->

			<?php wp_reset_query();  // Restore global post data stomped by the_post().?>
			
			<!-- Get category -->
			<?php $headline_category = get_category(6);

			// query arguments
		    $args=array(
		      "cat" => $headline_category->term_id,
		      'post_type' => 'post',
		      'post_status' => 'publish',
		      'posts_per_page' => 9,
		    );

		    $query = null;
		    $query = new WP_Query($args);

		    // if there is posts show the title
		    if( $query->have_posts() ) { ?>

			<h2 class="font-canela news-page__title" >
				<?php echo $headline_category->name; ?>
			</h2>
		    
		    <!-- posts container-->
		    <div class="cards sub-grid news-headlines" id="term_slug_<?php echo $headline_category->term_id; ?>">
			
				<!-- While there are posts show them -->
				<?php while ($query->have_posts()) : $query->the_post(); ?>
			      	
			      	<?php $external_link = get_field('external_news_link',get_the_ID()); ?>
			      	
						<div class="cards__card cards__card--headlines category_<?php echo $headline_category->term_id; ?>" >
								<a href="<?php echo  $external_link;  ?>" target="_blank">
									<div class="cards__info">
								    	<div class="cards__text">
											<p class="cards__date">
												<?php echo get_the_date(); ?>
											</p>
											<h3 class="cards__title cards__title--headlines-fk font-fk">
												<?php the_title(); ?>:
											</h3>
									    	<p class="cards__title cards__title--headlines font-canela">
									    		<?php echo get_the_excerpt(); ?>
									    	</p>
								    	</div>
									</div>
								</a>
						</div>

			    <?php endwhile; wp_reset_postdata(); } ?>

			</div><!-- /posts container-->	


		</div> <!-- /content-->

	</div> <!-- /grid-->

</main> <!-- /page container-->

<!-- 
-- 
-- video modal
-- 
--> 
<?php get_template_part(
    'partials/content',
    'modal',
    array(
        'type' => 'video',
        'id' => 'video-modal'
    )
); ?> 

<?php
get_footer();