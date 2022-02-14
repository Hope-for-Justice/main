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
    	$below_img = get_field('below_image');
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
				
			</h3>
			<h1 class="training-intro__title font-canela">
				<?php echo $page_hero['title'];?>
			</h1>
			<div class="training-intro__description">
				<p>
					<?php echo $page_hero['description'];?>	
				</p>
			</div>
			<div class="training-intro__cta">
				<a href="<?php echo $page_hero['button_link'];?>" class="button button--red">
					<div class="button__inner">
						<div class="button__text bold">
							<?php echo $page_hero['button_text'];?>
						</div>
					</div>
				</a>
				<div class="training-intro__link">
					<a id="learnMore">
						<?php echo $page_hero['more_link_text'];?>
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
				</h2>
				<p class="training-below-img__description">
					<?php echo $below_img['description'];?>
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

		<div class="training-second-content">
			<div class="training-second-content__line"></div>
			
			<h2 class="training-second-content__title font-canela">Accredited training</h2>
			
			<p class="training-second-content__desc">Hope for Justice's training is award-winning, including being named Best Public Service / Not-for-Profit Programme at the Training Journal Awards. Hope for Justice and Slave-Free Alliance is a Member of The CPD Certification Service (number 14454), showing our commitment to upholding and increasing standards in continuing professional development.</p>
			<div>
				<a href="<?php echo $page_hero['button_link'];?>" class="button button--red">
					<div class="button__inner">
						<div class="button__text bold">
							<?php echo $page_hero['button_text'];?>
						</div>
					</div>
				</a>
			</div>
		</div>

		<!-- 
		-- 
		-- Quote
		-- 
		--> 
		<div class="training-quote">
			<h2 class="training-quote__title">“This training was a great insight into modern-day slavery and human trafficking and really pitched at the right level... The feedback from our safeguarding champions was fantastic."</h2>
			<p class="training-quote__credit">Paul Corry, Adult Safeguarding, Blackpool Teaching Hospitals NHS Foundation Trust</p>
			<div class="training-quote__line"></div>
		</div>


	</div> <!-- /grid -->


	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>