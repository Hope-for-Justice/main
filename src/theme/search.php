<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<section id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php if (have_posts()) :
			$types = array('page', 'post');
			foreach ($types as $type) { ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php echo $type; ?>
					</h1>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while (have_posts()) :
					the_post(); ?>

					<?php if ($type == get_post_type()) { ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
							</header><!-- .entry-header -->
						</article><!-- #post-<?php the_ID(); ?> -->

					<?php } ?>


				<?php endwhile; ?>
			<?php rewind_posts();
			} ?>

			<div class="better-grid">
				<div style="grid-column: span 12;" class="archive-page__numbers">
					<?php the_posts_pagination(array(
						'mid_size'  => 1,
						'prev_next' => false,
					)); ?>
				</div>
			</div>

		<?php else :

			get_template_part('template-parts/content', 'none');

		endif;
		?>

	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
