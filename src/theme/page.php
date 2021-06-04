<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

	<main id="main" class="site-main" role="main">
		<div class="grid">
			<div class="default-page">
				<?php while ( have_posts() ) : the_post(); ?>
					
					<?php the_content(); ?>

				<?php endwhile; // end of the loop. ?>
			</div>
		</div>

	</main><!-- #main -->
<?php
get_footer();
