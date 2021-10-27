<?php
/**
 * Modern Slavery
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>		

	<?php $thumbnail = '';

	// Get the ID of the post_thumbnail (if it exists)
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);

	// if it exists
	if ($post_thumbnail_id) {
		$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
	} ?>
	
	<div class="grid">
		<!-- 
		-- 
		-- hero split --reverse
		-- 
		--> 
		<div class="hero-split hero-split--reverse">

			<div class="hero-split__img hero-split__img--bottom-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						<?php echo the_field('subtitle'); ?>
					</h3>
					<h1 class="hero-split__main-heading font-canela">
						<?php the_title(); ?>
					</h1>
					<div class="hero-split__desc">
						<?php the_content(); ?>
						<br><br>
					</div>
					<div>
						<a data-toggle="modal" data-target="#video-modal" data-src="<?php echo the_field('hero_video_link'); ?>" class="button button--green video-trigger">
							<div class="button__inner">
								<svg class="button__play-symbol" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.771 18.228">
									<g>
									  <path id="play" d="M9.984,7.564c-.074.021-.062-.019-.136.536-.083.624-.115,1.019-.2,2.471-.081,1.386-.128,2.007-.264,3.424a46.8,46.8,0,0,0-.211,5.848,23.71,23.71,0,0,0,.081,4.127,2.525,2.525,0,0,0,.307.9c.072.125.155.277.187.34a.779.779,0,0,0,.281.334,1.644,1.644,0,0,1,.174.134.286.286,0,0,0,.251.108,2.368,2.368,0,0,0,1.043-.428,16.726,16.726,0,0,1,3.112-1.339c1.047-.387,2.135-.826,2.99-1.209.651-.292.664-.3,1.66-.79.864-.428,1.264-.624,1.849-.9.485-.232,2.658-1.32,3.018-1.513.192-.1.451-.249.575-.323a7.489,7.489,0,0,0,1.728-1.419,1.822,1.822,0,0,0,.119-.226,1.908,1.908,0,0,1,.108-.207.824.824,0,0,0,.075-.179.964.964,0,0,1,.064-.179,1.993,1.993,0,0,0,.094-.317,1.283,1.283,0,0,0,.043-.424.641.641,0,0,0-.211-.5,7.834,7.834,0,0,0-1.266-.907c-.858-.573-1.4-.907-2.132-1.322-.492-.279-.894-.511-1.905-1.1-.457-.264-1.051-.606-1.32-.76l-.632-.358c-.479-.274-1.107-.609-2.075-1.113-.553-.287-1.228-.647-1.368-.726-.24-.138-1.205-.643-1.8-.941a6.483,6.483,0,0,0-1.594-.615A3.933,3.933,0,0,0,11.155,7.8a1.954,1.954,0,0,0,.447.694,9.963,9.963,0,0,0,1.8,1.624c.232.158,2.02,1.171,2.754,1.56.1.055.249.13.321.17s.4.209.726.377c1.6.824,3.456,1.817,4.471,2.392.809.458,1.8,1.028,2.075,1.192.372.223,1.147.713,1.16.736a1.059,1.059,0,0,1-.232.166c-.628.39-1,.6-1.928,1.083l-.472.247c-.283.147-1.849.93-2.009,1-.379.175-1.756.868-2.292,1.151-.672.358-1.718.888-2.216,1.126-.455.219-.815.389-.962.458-.373.175-1.083.507-1.281.6-.123.059-.224.106-.228.106s-.289.132-.636.294c-.626.292-1.16.56-1.551.779a2.149,2.149,0,0,1-.211.111A13.262,13.262,0,0,1,10.8,22.3c-.043-1.222-.074-1.747-.179-3.078-.064-.807-.094-1.254-.141-2.047-.034-.556-.051-1.273-.066-2.688-.017-1.605-.026-1.864-.094-3.018-.021-.347-.053-.866-.07-1.151-.021-.351-.032-.858-.034-1.566,0-.575-.006-1.066-.008-1.088C10.2,7.587,10.084,7.536,9.984,7.564Z" transform="translate(-9.163 -7.556)" fill="#fff"/>
									</g>
								</svg>
								<div class="button__text bold">
									<?php echo the_field('hero_button_text'); ?>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->

		<!-- 
		-- 
		-- text-slider flexslider
		--  
		-->
		<div class="color-block color-block--grey">
			<div class="text-slider">
				<h3 class="text-slider__heading">
					<?php echo the_field('slider_header'); ?>
				</h3>
				<div class="text-slider__slider">
					<div class="flexslider-text">
						<ul class="slides">
							<?php while (have_rows('sliders')) : the_row(); ?>
								<li>
									<p>
										<?php echo (get_sub_field('text')) ?>
										<span data-toggle="modal" data-target="#reference-modal" data-text="<?php echo (get_sub_field('reference')) ?>" class="reference__symbol">
											i
										</span>
									</p>
								</li>
							<?php endwhile; ?>
						</ul>
					
					</div>
					<a class="text-slider__prev" href="prev"></a>
					<a class="text-slider__next" href="next"></a>
				</div>
				<div>
					<a href="<?php echo the_field('slider_button_link'); ?>" class="button button--blue">
						<div class="button__inner">
							<div class="button__text bold">
								<?php echo the_field('slider_button_text'); ?>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- drag-cards
		--  
		-->
		<div class="drag-cards drag-cards--no-margin-top drag-cards--no-margin-bottom" id="dragCards">
			<h2 class="drag-cards__heading font-canela">
				<?php echo the_field('drag_cards_title'); ?>
				<span data-toggle="modal" data-target="#reference-modal" data-text="<?php echo the_field('drag_cards_title_reference'); ?>" class="reference__symbol">i</span>
			</h2>
			<div class="drag-cards__inner">
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">01</p>
					<h3 class="drag-cards__card-title font-fk">
						<?php echo the_field('card_1_title'); ?>
					</h3>
					<p class="drag-cards__card-desc">
					<?php echo the_field('card_1_text'); ?>
					</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">02</p>
					<h3 class="drag-cards__card-title font-fk">
						<?php echo the_field('card_2_title'); ?>
					</h3>
					<p class="drag-cards__card-desc">
						<?php echo the_field('card_2_text'); ?>
					</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">03</p>
					<h3 class="drag-cards__card-title font-fk">
						<?php echo the_field('card_3_title'); ?>
					</h3>
					<p class="drag-cards__card-desc">
						<?php echo the_field('card_3_text'); ?>
					</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">04</p>
					<h3 class="drag-cards__card-title font-fk">
						<?php echo the_field('card_4_title'); ?>
					</h3>
					<p class="drag-cards__card-desc">
						<?php echo the_field('card_4_text'); ?>
					</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">05</p>
					<h3 class="drag-cards__card-title font-fk">
						<?php echo the_field('card_5_title'); ?>
					</h3>
					<p class="drag-cards__card-desc">
						<?php echo the_field('card_5_text'); ?>
					</p>
				</div>
			</div>
			<div class="drag-cards__dots dots">
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
			</div>
		</div>
		
		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text">
			<h2 class="font-canela">
			<?php echo the_field('stats_title'); ?>
			</h2>
			<p class="plain-text__thinner">
				<?php echo the_field('stats_text'); ?> 
				<span data-toggle="modal" data-target="#reference-modal" data-text="<?php echo the_field('stats_reference'); ?>" class="reference__symbol">i</span>
			</p>
		</div>

		<!-- 
		-- 
		-- number-stats
		--  
		-->
		<div class="number-stats">
			<div class="number-stats__stat">
				<div class="number-stats__heading">
				<?php echo the_field('stat1_number'); ?>
				</div>
				<p>
				<?php echo the_field('stat1_text'); ?>
				</p>
			</div>
			<div class="number-stats__stat">
				<div class="number-stats__heading">
				<?php echo the_field('stat2_number'); ?>
				</div>
				<p>
				<?php echo the_field('stat2_text'); ?>
				</p>
			</div>
			<div class="number-stats__stat">
				<div class="number-stats__heading">
				<?php echo the_field('stat3_number'); ?>
				</div>
				<p>
				<?php echo the_field('stat3_text'); ?>
				</p>
			</div>
			<div class="number-stats__stat">
				<div class="number-stats__heading">
				<?php echo the_field('stat4_number'); ?>
				</div>
				<p>
				<?php echo the_field('stat4_text'); ?>
				</p>
			</div>
		</div>

		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text plain-text--margin-bottom">
			<p class="plain-text__thinner">
				<?php echo the_field('stats_footer_text'); ?>  
				<span data-toggle="modal" data-target="#reference-modal" data-text="
				<?php echo the_field('stats_footer_reference'); ?>" class="reference__symbol">i</span>
			</p>
		</div>

		<!-- 
		-- 
		-- color block - plain-text
		--  
		-->
		<div class="color-block color-block--grey">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2 class="font-canela">
						<?php echo the_field('plain_text1_title'); ?>
						<span data-toggle="modal" data-target="#reference-modal" data-text="<?php echo the_field('plain_text1_reference'); ?>" class="reference__symbol">i</span>
					</h2>
					<p>
						<?php echo the_field('plain_text1_text'); ?>			
					</p>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- color block - plain-text
		--  
		-->
		<div class="color-block color-block--background-img" style="background-image: url('<?php echo the_field('plain_text2_image'); ?>');">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2 class="font-canela">
					<?php echo the_field('plain_text2_title'); ?>
						<span data-toggle="modal" data-target="#reference-modal" data-text="<?php echo the_field('plain_text2_reference'); ?>" class="reference__symbol">i</span>
					</h2>
					<p>
					<?php echo the_field('plain_text2_text'); ?>
					</p>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- color block - plain-text
		--  
		-->
		<div class="color-block">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2 class="font-canela">
						<?php echo the_field('plain_text3_title'); ?>
						<span data-toggle="modal" data-target="#reference-modal" data-text="<?php echo the_field('plain_text3_reference'); ?>" class="reference__symbol">i</span>
					</h2>
					<p>
					<?php echo the_field('plain_text3_text'); ?></p>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- hero split --reverse
		-- 
		--> 
		<div class="hero-split hero-split--reverse">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo the_field('footer_hero_image'); ?>');">
			</div>

			<div class="hero-split__content hero-split__content--grey">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">	
						<?php echo the_field('footer_hero_subtitle'); ?>
					</h3>
					<h2 class="hero-split__smaller-main-heading font-canela">		
						<?php echo the_field('footer_hero_title'); ?>
					</h2>
					<div>
						<a href="<?php echo the_field('footer_hero_button_link'); ?>" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									<?php echo the_field('footer_hero_button_text'); ?>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->


	</div> <!-- /grid -->

	<!-- 
	-- 
	-- reference modal
	-- 
	--> 
	<?php get_template_part(
	    'partials/content',
	    'modal',
	    array(
	        'type' => 'reference',
	        'id' => 'reference-modal'
	    )
	); ?>

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



	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>