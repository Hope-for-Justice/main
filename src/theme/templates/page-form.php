<?php
/**
 * Template Name: Form page
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

		<div class="grid">
			<!-- 
			-- 
			-- header
			--  
			-->
			<div class="color-block color-block--red">
				<div class="sub-grid">
					<header class="form-page__header">
						<h1 class="form__heading form__heading--no-margin font-fk">
							<?php 
								if($GLOBALS['userInfo'] 
								&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])){ 
							 		the_field('norway_form_title'); 
							 	} else {
							 		the_field('form_title');
							 	}
							?>		
						</h1>
					</header>
				</div>
			</div><!-- /header -->

			<!-- 
			-- 
			-- content
			--  
			-->
			<div class="color-block color-block--grey">
				<div class="sub-grid">
					<div class="form-page__content">
						<?php 
							if($GLOBALS['userInfo'] 
							&& in_array($GLOBALS['userInfo'], $GLOBALS['us'])){ 
								//US
								echo do_shortcode( get_field('us_form') );
							} 
							else if($GLOBALS['userInfo'] 
							&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { 
								//Norway
								echo do_shortcode( get_field('norway_form') );
							}
							else if($GLOBALS['userInfo'] 
							&& in_array($GLOBALS['userInfo'], $GLOBALS['aus'])) {
								//AUS
								echo do_shortcode( get_field('aus_form') );
							}
							else {
								//UK fallback
								echo do_shortcode( get_field('uk_form') );
							} ?>
					</div>
				</div>
			</div><!-- /content -->

		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>
