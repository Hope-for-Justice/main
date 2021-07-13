<?php


get_header();
?>

<main id="main" class="site-main single_event">
	<?php 
	$event_image = get_the_post_thumbnail_url(); 
	if(!empty(get_field('event_image'))) {
		$event_image = get_field('event_image'); 
	} 
	?>
	<div class="container ">
		<div class="row">
			<div class="col-md-8 mx-auto">
				<p class="cards__date event_cards__date"><?php echo  get_the_date(); ?></p>
			</div>
			<div class="col-md-8 mx-auto">
				<h1 class="single_events__title font-canela"><?php the_title(); ?></h1>
			</div>
			<div class="col-md-8 mx-auto">
				<img src="<?php echo $event_image; ?>" class="img-fluid">
			</div>
			<div class="col-md-8 mx-auto">
				<div class="single_event_desc"><?php the_content(); ?></div>
			</div>
		</div>
			

	 	
		
	



</main><!-- /#main -->

<?php get_footer(); ?>