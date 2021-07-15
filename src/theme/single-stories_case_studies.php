<?php get_header(); ?>



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $stitle_color = get_field('title_color',$post->ID); ?>
<?php  $args=array(
'post__not_in' => array($post->ID),
'post_type' => 'stories_case_studies',
'post_status' => 'publish',
'posts_per_page' => -1,
);
$post_link_url = '';
if(get_adjacent_post(false,'',false)) {
	$post_link_url = get_permalink( get_adjacent_post(false,'',false)->ID ); 
} else {
	$post_link_url = get_permalink(get_adjacent_post(false, '', true)->ID);
}
$query = null;
$query = new WP_Query($args);
?>

<!-- Page container -->
<div class="news-inner grid stories_case_studies_inner">
	<!-- container for post --> 
	<div class="news-inner__post">
		<!-- Post image -->
		<div class="news-inner__img-container">
			<img class="news-inner__hero-img" src="<?php echo get_the_post_thumbnail_url(); ?>">
			<div class="single_title_stories"><?php echo get_the_title(); ?></div>
		</div>
		<div class="news-inner__content">
			<div class="news-inner__info">
					
					
					<div class="custom-hr" style="border-top: 2px solid <?php echo $stitle_color; ?>;"></div>
					<div class="news-inner__post-content" >
						<?php the_content(); ?>
					</div>
					<h1 class="news-inner__post-heading_content" >
						<?php echo get_field('end_result',$post->ID); ?>
					</h1>
					
					<!-- post footer -->
					<div class="news-inner__footer">
						<!-- Back to news button -->
						<div class="news-inner__button">
							<a class="button button--black" href="<?php echo $post_link_url;?>">Read next Case</a>
						</div>
						<div class="news-inner__share">
							<!-- social icons -->
							<ul class="news-inner__socials">
								<li>
									<a href="#">
										<img class="news-inner__social-icon" src="<?php echo get_template_directory_uri().'/assets/img/linkedin.svg'; ?>" alt="">
									</a>
								</li>
								
								<li>
									<a href="#">
										<img class="news-inner__social-icon" src="<?php echo get_template_directory_uri().'/assets/img/twitter-seeklogo.com.svg'; ?>" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img class="news-inner__social-icon" src="<?php echo get_template_directory_uri().'/assets/img/fb.svg'; ?>" alt="">
									</a>
								</li>
							</ul>
							<p class="news-inner__share-text">Share this story</p>
							
							
						</div>
					</div>
			</div><!-- /row -->
		</div><!-- /container -->
	</div>
	<?php endwhile; ?>
	<?php endif; ?>

	<?php if( $query->have_posts() ) { ?>
	<!-- Cards for more news-->		 	
	<div class="news-inner__cards">
		
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php $title_color = get_field('title_color'); ?>
				<!-- if the card is not blog category -->	
				
					<div class="cards__card" >
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
							    	<div class="sidebar-news-inner__button">
							    		<span class="button button--black">READ STORY</span>
							    	</div>
							  	</div>
							</div>
						</a>
						
					</div>
				<!-- if the card is blog category -->
				<?php   endwhile; ?>

		


	</div>


	<?php } ?>

</div><!-- /news page -->

	
		

<?php get_footer(); ?>