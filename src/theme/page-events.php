<?php
/**
 * Template Name: Events
 */

get_header();
?>

<main id="main" class="site-main">

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="events__title"><?php echo  get_the_title(); ?></h1>
			</div>
			<div class="col-md-8">
				<p class="event_desc"><?php echo get_the_content(); ?></p>
			</div>
		</div>
			<?php
				$args=array(
				'meta_key' => 'pin_event',
				
				'orderby' => 'meta_value date',
				'order'   => 'DESC',
				'post_type' => 'events',
				'post_status' => 'publish',
				'posts_per_page' => -1,


				);
				$query = null;
				$query = new WP_Query($args);
				if( $query->have_posts() ) { 
				 	while ($query->have_posts()) : $query->the_post(); ?>
				 	
				 		<?php 
				 		$sign_up = '';
				 		$sign_up_data = '';
				 		$learn_more = '';
				 		$learn_more_data = '';

				 		$event_image = get_the_post_thumbnail_url(); 
				 		if(!empty(get_field('event_image'))) {
				 			$event_image = get_field('event_image',$query->ID); 
				 		} 
				 		if(!empty(get_field('sign_up'))) {
				 			$sign_up = get_field('sign_up',$query->ID); 
				 			$sign_up_data = '<a class="button button--red " href="'.$sign_up.'">Sign Up</a>';
				 		}
				 		if(!empty(get_field('learn_more'))) {
				 			$learn_more = get_field('learn_more',$query->ID); 
				 			$learn_more_data = '<a class="button button--white " href="'.$learn_more.'">Learn more</a>';
				 		}
				 		
				 		?>

				 		<div class="card  event__cards " >
				 			<div class="row no-gutters card__data">
				 				<div class="col-md-6">
				 					<a href="<?php echo get_the_permalink();?>">
				 					<img src="<?php echo $event_image; ?>" class="custom__img-fluid">
				 					</a>

				 				</div>
				 				<div class="col-md-6">
				 					<div class="card-body event__card-body">
				 						<p class="cards__date event_cards__date">
											<?php echo get_the_date(); ?>
										</p>
				 						<h3 class="cards__title font-canela event__cards__title">
										<?php the_title(); ?>	
										</h3>
				 						<p class="cards__excerpt"> <?php echo wp_trim_words( get_the_content(), 35, '' ); ?></p>
				 						<div class="card__buttons mt-5">
				 						<div class="sign__up_btn d-inline-block">	
				 							<?php echo $sign_up_data; ?>
				 						</div>
				 						<div class="learn__more_btn d-inline-block ml-5">	
				 							<?php echo $learn_more_data; ?>
				 						</div>
				 						
				 					</div>
				 				</div>
				 			</div>
				 		</div>
				 		</div>
			<?php endwhile; wp_reset_postdata();   } ?>
		
	



</main><!-- /#main -->

<?php get_footer(); ?>