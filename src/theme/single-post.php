<?php get_header(); ?>

<!-- social sharing -->
<?php $postUrl = 'http' . ( isset( $_SERVER['HTTPS'] ) ? 's' : '' ) . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>

<?php 
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
$category_name = $categories[0]->name;
$category_slug = $categories[0]->slug;

	if(is_category('videos')){
		die('2121');
		get_template_part('content','yourCategory');
	}else{
		get_template_part('content','single.php');
	}

?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php  $args=array(
'post__not_in' => array($post->ID),
"cat" => $category_id,
'post_type' => 'post',
'post_status' => 'publish',
'posts_per_page' => 9,
);

$query = null;
$query = new WP_Query($args);
?>

<!-- Page container -->
<div class="news-inner grid news-inner-cat-<?php echo $category_id ?>">
	<!-- container for post --> 
	<div class="news-inner__post">
		<!-- Post image -->
		<div class="news-inner__img-container">
			<img class="news-inner__hero-img" src="<?php echo get_the_post_thumbnail_url(); ?>">
		</div>
		<div class="news-inner__content">
			<div class="news-inner__info">
					<!-- Post date -->
					<h3 class="news-inner__date">
						<?php echo get_the_date(); ?>	
					</h3>

					<!-- Post title -->
					<h1 class="b-title font-canela">
						<?php the_title(); ?>
					</h1>
					
					<!-- Post content -->
					<div class="news-inner__post-content">
						<?php the_content(); ?>
					</div>
					
					<!-- post footer -->
					<div class="news-inner__footer">
						<!-- Back to news button -->
						<div class="news-inner__button">
							<a class="button button--red" href="<?php echo home_url().'/news-media/';?>">Back To main <br> News Page</a>
						</div>
							<div class="news-inner__share">
								<!-- social icons -->
								<p class="news-inner__share-text">Share this post:</p>
								<ul class="news-inner__socials">
									<li>
										<a href="https://twitter.com/intent/tweet?url=<?php echo $postUrl; ?>&text=<?php echo the_title(); ?>&via=<?php the_author_meta( 'twitter' ); ?>">
											<img class="news-inner__social-icon" src="<?php echo get_template_directory_uri().'/assets/img/twitter-seeklogo.com.svg'; ?>" alt="">
										</a>
									</li>
									<li>
										<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $postUrl; ?>">
											<img class="news-inner__social-icon" src="<?php echo get_template_directory_uri().'/assets/img/fb.svg'; ?>" alt="">
										</a>
									</li>
								</ul>
								
							</div>
					</div>
			</div><!-- /row -->
		</div><!-- /container -->
	</div>
	<?php endwhile; ?>
	<?php endif; ?>

	<?php if( $query->have_posts() ) { ?>
	<!-- Cards for more news-->		 	
	<div class="news-inner__cards scategory_<?php echo $category_id; ?>" >
		<h2 class="font-canela b-title--smaller">
			<?php echo $category_name; ?>
		</h2>
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<!-- if the card is not blog category -->	
				<?php if($category_id != 7) { ?>
					<div class="cards__card" >
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
				<!-- if the card is blog category -->
				<?php } elseif($category_id == 7) {  ?>
					<a href="<?php the_permalink() ?>">
						<div class="cards__card cards__card--blog" >	
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
						</div>
					</a>
	       
			<?php } endwhile; ?>

		<!-- see more button -->
  		<div class="news-inner__cards-button">
  			<a href="javascript:void(0)" class="button button--white more_postss" data-term="<?php echo $category_id; ?>" data-href="<?php echo home_url().'/news/category/'.$category_slug.'/';?>">
  				<div class="button__inner">
  					<div class="button__text bold">See more</div>
  				</div>
  			</a>
  		</div>


	</div>


	<?php } ?>

</div><!-- /news page -->


			
		

<?php get_footer(); ?>