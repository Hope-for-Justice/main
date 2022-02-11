<?php
/**
 * Template Name: Training
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main training" role="main">

	<?php while ( have_posts() ) : the_post(); ?>		

	<?php $thumbnail = '';

	// Get the ID of the post_thumbnail (if it exists)
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);

	// if it exists
	if ($post_thumbnail_id) {
		$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
	} 
		//ACF GROUPS
    	$page_hero = get_field('page_hero');
    	$below_img = get_field('below_img');
    	$second_section = get_field('second_section');
	?>

	
	
	<div class="grid">
		
		<!-- 
		-- 
		-- hero
		-- 
		--> 
		<div class="training-hero-img" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
		</div>

		<div class="training-intro">
			<h3 class="training-intro__subtitle">
				<?php echo $page_hero['subtitle'];?>
				Learn the skills to respond
			</h3>
			<h1 class="training-intro__title font-canela">
				<?php echo $page_hero['title'];?>
				Modern slavery<br>Training
			</h1>
			<div class="training-intro__description">
				<p>
					<?php echo $page_hero['description'];?>
					Do you work with potential victims of modern slavery? Hope for Justice believes in multi-agency working and is keen to work with and train law enforcement, medical professionals, social services, community outreach programmes and other frontline agencies and organisations to tackle the issue of modern slavery.
				</p>
			</div>
			<div class="training-intro__cta">
				<a href="<?php echo $page_hero['button_link'];?>" class="button button--red">
					<div class="button__inner">
						<div class="button__text bold">
							<?php echo $page_hero['button_text'];?>
							Make a training<br>enquiry
						</div>
					</div>
				</a>
				<div class="training-intro__link">
					<a id="learnMore">
						<?php echo $page_hero['more_link_text'];?>
						Learn more
					</a>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- below img
		-- 
		--> 
		<div class="training-below-img">
			<div class="sub-grid">
				<h2 class="font-canela training-below-img__title">
					<?php echo $below_img['title'];?>
					The value of training		
				</h2>
				<p>
					<?php echo $below_img['description'];?>
					We believe that by equipping people who are specialists in their own field with relevant, comprehensive and practical guidance we can increase the number of victims identified and improve the response and help offered by organisations like yours.
				</p>
				<ul class="training-dropdown">
					<?php while (have_rows('below_image')) : the_row(); ?>
						<?php while (have_rows('dropdown')) : the_row(); ?>
						<li class="training-dropdown__trigger">
							<div class="training-dropdown__header">
								<h2 class="font-canela training-dropdown__title"><?php echo (get_sub_field('title'))?></h2>
								<img class="training-dropdown__cross" src="<?php echo get_template_directory_uri().'/assets/img/cross-red.svg'; ?>">
							</div>
							<p class="training-dropdown__content">
								<?php echo (get_sub_field('description'))?>
							</p>
						</li>
						<?php endwhile; ?>
					<?php endwhile; ?>
				</ul>
			</div>

		</div>

		<!-- 
		-- 
		-- second section
		-- 
		--> 
		<div class="training-second-img" style="background-image: url('<?php echo $second_section['img']; ?>');">
		</div>



	</div> <!-- /grid -->


	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>