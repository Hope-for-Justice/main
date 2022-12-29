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
		<div class="better-grid">
			<div class="archive-page--search">

				<?php if (have_posts()) : ?>

					<div style="height: clamp(40px, 8vw, 80px)"></div>
					<header class="page-header">
						<h1 style="font-size: var(--wp--preset--font-size--huge); font-weight:bold;">
							<?php
							/* translators: %s: search query. */
							printf(esc_html__('Search results for: %s', 'hope-for-justice-2021'), '<span>' . get_search_query() . '</span>');
							?>
						</h1>
					</header><!-- .page-header -->
					<div style="height: clamp(24px, 5vw, 40px);"></div>

					<?php
					/* Start the Loop */
					while (have_posts()) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part('template-parts/content', 'search');

					endwhile; ?>

					<div class="archive-page__numbers archive-page__numbers--search">
						<?php the_posts_pagination(array(
							'mid_size'  => 1,
							'prev_next' => false,
						)); ?>
					</div>




				<?php else :

					get_template_part('template-parts/content', 'none');

				endif;
				?>
				<div style="height: clamp(40px, 8vw, 80px)"></div>
			</div>
		</div>
	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
