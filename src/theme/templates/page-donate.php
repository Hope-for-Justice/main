<?php
/**
 * Template Name: Donate
 *
 * @package hopeforjustice-2014
 */

get_header(); ?>


	<main id="main" class="site-main donate" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

		<?php $thumbnail = '';

		// Get the ID of the post_thumbnail (if it exists)
		$post_thumbnail_id = get_post_thumbnail_id($post->ID);

		// if it exists
		if ($post_thumbnail_id) {
			$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
		} ?>

		<img class="donate__img" src="<?php echo $thumbnail[0]; ?>" alt="reintegration of a young girl back to her family">
		<div class="grid">

			<!-- 
			-- 
			-- Description
			--  
			-->
			<div class="donate__info donate__info--monthly">	
				<h2 class="donate__title font-fk">
					<?php the_field('donate_title_monthly');?>		
				</h2>
				<p>
					<?php the_field('donate_description_monthly');?>	
				</p>
			</div>

			<div class="donate__info donate__info--once">	
				<h2 class="donate__title font-fk">
					<?php the_field('donate_title_once');?>		
				</h2>
				<p>
					<?php the_field('donate_description_once');?>	
				</p>
			</div>


			<!-- 
			-- 
			-- Giving
			--  
			-->
			<div class="donate__giving">
				<!-- 
				-- 
				-- Toggle
				--  
				-->				
				<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) {?> 

				<a href="<?php echo the_field('norway_donate_form_monthly')?>">
					<div class="donate__toggle-container">
						<div class="donate__toggle toggle toggle--black">
							<div class="toggle__option">Give once</div>
							<div class="toggle__option">Give monthly</div>
							<div class="toggle__slider">Giving </div>
						</div>
					</div>
				</a>

				<?php } else { ?>

				<div class="donate__toggle-container">
					<div class="donate__toggle toggle toggle--black">
						<div class="toggle__option">Give once</div>
						<div class="toggle__option">Give monthly</div>
						<div class="toggle__slider">Giving </div>
					</div>
				</div>

				<?php } ?>

				<div class="donate__form donate__form--monthly">
					<?php 
						if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
							<!-- US -->
							<div id="usaFormMonthly">
								<?php echo do_shortcode( get_field('us_donate_form_monthly') ); ?>
							</div>
						<?php } 
						else if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { ?>
							<!-- Norway 
								one off default for norway
							-->
							<div id="norwayForm">
								<?php echo do_shortcode( get_field('norway_donate_form_once') ); ?>
							</div>
						<?php } else { ?>
							<!-- UK fallback -->
							<div id="ukFormMonthly">
								<?php echo do_shortcode( get_field('uk_donate_form_monthly') ); ?>
							</div>
						<?php } ?>
				</div>
				<div class="donate__form donate__form--once">
					<?php 
						if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
							<!-- US -->
							<div id="usaForm">
								<?php echo do_shortcode( get_field('us_donate_form_once') );?>
							</div>
						<?php } 
						else if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { ?>
							<!-- Norway -->
							 <div id="norwayForm">
								<?php echo do_shortcode( get_field('norway_donate_form_once') ); ?>
							</div>
						<?php } 
						else { ?>
							<!-- UK fallback -->
							<div id="ukForm">
								<?php echo do_shortcode( get_field('uk_donate_form_once') ); ?>
							</div>
						<?php } ?>
				</div>
			</div><!-- / giving -->


		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

	<?php if($GLOBALS['userInfo'] 
	&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { ?>
		<input id="initialDonationType" type="hidden" name="geo" value="once">
	<?php } ?>

<?php get_footer(); ?>