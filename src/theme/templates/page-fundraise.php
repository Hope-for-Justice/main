<?php
/**
 * Template Name: Fundraise
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main fundraise" role="main">

	<?php while ( have_posts() ) : the_post(); ?>		

	<?php $thumbnail = '';

	// Get the ID of the post_thumbnail (if it exists)
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);

	// if it exists
	if ($post_thumbnail_id) {
		$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
	} ?>


	<?php
		//ACF GROUPS
    	$page_hero = get_field('page_hero');
    	$page_hero_usa = get_field('page_hero_usa');
    	$below_hero = get_field('below_hero');
    	$below_hero_usa = get_field('below_hero_usa');
    	$steps = get_field('steps');
    	$fundraise_option_a = get_field('fundraise_a');
    	$fundraise_option_b = get_field('fundraise_b');
    	$fundraise_option_b_usa = get_field('fundraise_b_usa');
    	$bottom_slice = get_field('bottom_slice');
	?>

	
	
	<div class="grid">
		
		<!-- 
		-- 
		-- hero
		-- 
		--> 
		<div class="fundraise-hero-img" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
		</div>

		<div class="fundraise-intro">
			<h3 class="fundraise-intro__subtitle">
				<?php echo $page_hero['sub_header'];?>
			</h3>
			<h1 class="fundraise-intro__title font-canela">
				<?php echo $page_hero['main_heading'];?>
			</h1>
			<div class="fundraise-intro__description">
				<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
					<p><?php echo $page_hero_usa['description'];?></p>
				<?php } else { ?>
					<p><?php echo $page_hero['description'];?></p>
				<?php }?>
			</div>
			<div class="fundraise-intro__button-con">
				<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
					<a href="<?php echo $page_hero_usa['button_link'];?>" class="button button--green">
						<div class="button__inner">
							<div class="button__text bold">
								<?php echo $page_hero_usa['button_text'];?>
							</div>
						</div>
					</a>
				<?php } else { ?>
					<a href="<?php echo $page_hero['button_link'];?>" class="button button--green">
						<div class="button__inner">
							<div class="button__text bold">
								<?php echo $page_hero['button_text'];?>
							</div>
						</div>
					</a>
				<?php }?>

			</div>
		</div>


		<!-- 
		-- 
		-- below img
		-- 
		--> 
		<div class="fundraise-below-img">
			<div class="sub-grid">
				<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
					<h2 class="font-canela"><?php echo $below_hero_usa['title'];?></h2>
					<p><?php echo $below_hero_usa['description'];?></p>
				<?php } else { ?>
					<h2 class="font-canela"><?php echo $below_hero['title'];?></h2>
					<p><?php echo $below_hero['description'];?></p>
				<?php }?>
			</div>
		</div>

		<!-- 
		-- 
		-- steps
		-- 
		-->
		<div class="fundraise-steps">
			<div class="sub-grid fundraise-steps__grid">
				<div class="fundraise-steps__step fundraise-steps__step--left">
					<div class="sub-grid">
						<div class="fundraise-steps__step-header">
							<div class="fundraise-steps__number font-fk">1</div>
							<h2 class="font-fk fundraise-steps__title"><?php echo $steps['step_1_title'];?></h2>
						</div>
						<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){  echo $steps['step_1_content_usa'];
						 } else { 
							echo $steps['step_1_content'];
						 }?>

					</div>
				</div>
				<div class="fundraise-steps__step">
					<div class="sub-grid">
						<div class="sub-grid">
							<div class="fundraise-steps__step-header">
								<div class="fundraise-steps__number font-fk">2</div>
								<h2 class="font-fk fundraise-steps__title"><?php echo $steps['step_2_title'];?></h2>
							</div>
							<?php echo $steps['step_2_content'];?>
						</div>
					</div>
				</div>
				<div class="fundraise-steps__step fundraise-steps__step--left">
					<div class="sub-grid">
						<div class="sub-grid">
							<div class="fundraise-steps__step-header">
								<div class="fundraise-steps__number font-fk">3</div>
								<h2 class="font-fk fundraise-steps__title"><?php echo $steps['step_3_title'];?></h2>
							</div>
							<?php echo $steps['step_3_content'];?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- option
		--  
		-->
		<div class="fundraise-option__img" style="background-image: url('<?php echo $fundraise_option_a['image'];?>');"></div>

		<div class="fundraise-option__content">
			<h2 class="font-canela fundraise-option__title"><?php echo $fundraise_option_a['heading'];?></h2>
			<p>
				<?php echo $fundraise_option_a['description'];?>
				
			</p>
			<div><a href="<?php echo $fundraise_option_a['button_link'];?>" class="button button--green">
				<?php echo $fundraise_option_a['button_text'];?></a></div>
		</div>

		<!-- 
		-- 
		-- option
		--  
		-->

		<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
			

			<div class="fundraise-option__img fundraise-option__img--reverse" style="background-image: url('<?php echo $fundraise_option_b_usa['image'];?>');"></div>

			<div class="fundraise-option__content fundraise-option__content--reverse">
				<h2 class="font-canela fundraise-option__title"><?php echo $fundraise_option_b_usa['heading'];?></h2>
				<p>
					<?php echo $fundraise_option_b_usa['description'];?>
					
				</p>
				<div><a href="<?php echo $fundraise_option_b_usa['button_link'];?>" class="button button--green"><?php echo $fundraise_option_b_usa['button_text'];?></a></div>
			</div>



		<?php } else {  ?>

			<div class="fundraise-option__img fundraise-option__img--reverse" style="background-image: url('<?php echo $fundraise_option_b['image'];?>');"></div>

			<div class="fundraise-option__content fundraise-option__content--reverse">
				<h2 class="font-canela fundraise-option__title"><?php echo $fundraise_option_b['heading'];?></h2>
				<p>
					<?php echo $fundraise_option_b['description'];?>
				</p>
				<div><a href="<?php echo $fundraise_option_b['button_link'];?>" class="button button--green"><?php echo $fundraise_option_b['button_text'];?></a></div>
			</div>

		<?php } ?>

		<!-- 
		-- 
		-- events
		--  
		-->
		<div class="fundraise-events">
			<div class="sub-grid">
				<div class="fundraise-events__content">
					<h2 class="font-canela"><?php echo $bottom_slice['title'];?></h2>
					<p>
						<?php echo $bottom_slice['description'];?></p>
					<a href="<?php echo $bottom_slice['button_link'];?>" class="button button--green"><?php echo $bottom_slice['button_text'];?></a>
				</div>
			</div>
		</div>


	</div> <!-- /grid -->


	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>