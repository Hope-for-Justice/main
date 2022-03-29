<?php
/**
 * Template Name: Ukraine crisis
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main ukraine-crisis" role="main">

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
			-- Hero
			--  
			-->
			<h1 class="ukraine-seo-title">UKRAINE: HUMAN TRAFFICKING CRISIS APPEAL</h1>
			<div class="ukraine-hero" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="ukraine-hero__content">
				<img class="ukraine-hero__svg" src="https://hopeforjustice.org/wp-content/uploads/2022/03/ukrain-title.svg">

				<p class="ukraine-hero__info"><?php echo the_field('hero_text'); ?></p>
			</div>

			<!-- 
			-- 
			-- Inline Giving
			--  
			-->
			<div id="ukraineGiving" class="ukraine-giving">
				<!-- 
				-- 
				-- Giving
				--  
				-->
				<?php 
					if($GLOBALS['userInfo'] 
					&& in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
						<!-- US -->
						<div id="usaForm">
							<?php echo do_shortcode( get_field('usa_form') );?>
						</div>
					<?php } 
					else if($GLOBALS['userInfo'] 
					&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { ?>
						<!-- Norway -->
						<div id="norwayForm">
							<?php echo do_shortcode( get_field('norway_form') ); ?>
						</div>
					<?php } 
					else { ?>
						<!-- UK fallback -->
						<div id="ukForm">
							<?php echo do_shortcode( get_field('uk_form') ); ?>
						</div>
					<?php } ?>
			</div><!-- / giving -->


			<!-- 
			-- 
			-- first quote
			--  
			-->
			<div class="ukraine-quote">
				<div class="ukraine-quote__circle" style="background-image: url('<?php echo the_field('circle_img'); ?>;"></div>
				<p class="ukraine-quote__quote">
					<?php echo the_field('quote_1'); ?>
				</p>
				<p class="ukraine-quote__attr">
					<?php echo the_field('quote_1_attr'); ?>
				</p>
			</div>

			<!-- 
			-- 
			-- second section
			--  
			-->
			<div class="ukraine-second">
				<div class="sub-grid">
					<h2 class="ukraine-second__title"><?php echo the_field('second_section_title'); ?></h2>
					<p class="ukraine-second__text"><?php echo the_field('second_section_text'); ?></p>
					<div class="ukraine-second__button"><a class="button button--white ukraineDonate">Donate now</a></div>
					<div class="ukraine-second__img" style="background-image: url('<?php echo the_field('second_image'); ?>;"></div>
				</div>
			</div>

			<!-- 
			-- 
			-- third section
			--  
			-->
			<h2 class="ukraine-third__title"><?php echo the_field('third_section_title'); ?></h2>
			<p class="ukraine-third__text"><?php echo the_field('third_section_text'); ?></p>
			<a class="ukraine-third__img" href="<?php echo the_field('letter_link'); ?>" target="_blank"><img class="ukraine-third__img" src="<?php echo the_field('letter_image'); ?>"></a>

			<!-- 
			-- 
			-- second-quote
			--  
			-->
			<div class="ukraine-second-quote">
				<p class="ukraine-second-quote__quote"><?php echo the_field('second_quote'); ?></p>
				<div class="ukraine-second-quote__button"><a class="button button--white ukraineDonate">Donate now</a></div>
			</div>


			<!-- 
			-- 
			-- last
			--  
			-->
			<h2 class="ukraine-last__title">
				<?php echo the_field('fourth_section_title'); ?>
			</h2>
			<p class="ukraine-last__text">
				<?php echo the_field('fourth_section_text'); ?>
			</p>
			<img class="ukraine-last__img" src="<?php echo the_field('poster_image'); ?>">
			<img class="ukraine-last__img" src="<?php echo the_field('poster_image_2'); ?>">


		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->


<?php get_footer(); ?>