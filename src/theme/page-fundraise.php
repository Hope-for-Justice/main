<?php
/**
 * Fundraise
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
    	$below_hero = get_field('below_hero');
    	$fundraise_with_facebook = get_field('fundraise_with_facebook');
    	$fundraise_with_jg = get_field('fundraise_with_jg');
    	$bottom_slice = get_field('fundraise_with_jg');
	?>

	
	
	<div class="grid">
		<!-- 
		-- 
		-- hero split
		-- 
		--> 
		<div class="hero-split fundraise-top hero-split--reverse">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content">
				<div class="hero-split__content-inner">
					<h3>
						<?php echo $page_hero['sub_header'];?>
					</h3>
					<h1 class="font-canela">
						<?php echo $page_hero['main_heading'];?>
					</h1>
					<p class="hero-split__desc">
						<?php echo $page_hero['description'];?>
					</p>
				</div>
			</div>
		</div><!-- /hero-split -->

		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="color-block color-block--grey">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2 class="font-canela"><?php echo $below_hero['title'];?></h2>
					<p><?php echo $below_hero['description'];?>
					</p>
				</div>
			</div>
		</div><!-- /plain-text -->

		<!-- 
		-- 
		-- hero split facebook
		-- 
		--> 
		<div class="hero-split">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo $fundraise_with_facebook['image'];?>');">
			</div>

			<div class="hero-split__content">
				<div class="hero-split__content-inner">
					<img class="fundraise-facebook-image" src="<?php echo $fundraise_with_facebook['logo'];?>"> 
					<h1 class="font-canela">
						<?php echo $fundraise_with_facebook['heading'];?>
					</h1>
					<p class="hero-split__desc">
						<?php echo $fundraise_with_facebook['description'];?>
					</p>
					<div class="hero-spit__button">
						<a href="<?php echo $fundraise_with_facebook['button_link'];?>" class="button button--green">
							<div class="button__inner">
								<div class="button__text bold">
									<?php echo $fundraise_with_facebook['button_text'];?>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->
		<!-- 
		-- 
		-- hero split just giving
		-- 
		--> 
		<div class="hero-split hero-split--reverse">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo $fundraise_with_jg['image'];?>');">
			</div>

			<div class="hero-split__content">
				<div class="hero-split__content-inner">
					<img class="fundraise-jg-image" src="<?php echo $fundraise_with_jg['logo'];?>"> 
					<h1 class="font-canela">
						<?php echo $fundraise_with_jg['heading'];?>
					</h1>
					<p class="hero-split__desc">
						<?php echo $fundraise_with_jg['description'];?>
					</p>
					<div class="hero-spit__button">
						<a href="<?php echo $fundraise_with_jg['button_link'];?>" class="button button--green">
							<div class="button__inner">
								<div class="button__text bold">
									<?php echo $fundraise_with_jg['button_text'];?>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>

		</div><!-- /hero-split -->

		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="color-block color-block--grey">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2 class="font-canela">How your fundraising could change the world</h2>
					<p class="margin-bottom">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.
					</p>
					<a href="#" class="button button--green">
						<div class="button__inner">
							<div class="button__text bold">
								See current events
							</div>
						</div>
					</a>
				</div>
			</div>
		</div><!-- /plain-text -->



	</div> <!-- /grid -->


	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>