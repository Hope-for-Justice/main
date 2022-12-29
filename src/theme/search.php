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

<main>
	<div style="height: clamp(40px, 8vw, 80px)"></div>
	<div class="better-grid">
		<div class="archive-page--search">
			<?php
			$s = get_search_query();
			$args = array(
				's' => $s
			);
			// The Query
			$the_query = new WP_Query($args);
			if ($the_query->have_posts()) {
				_e("<h1 style='font-size: var(--wp--preset--font-size--huge); font-weight:bold;'>Search results for: " . get_query_var('s') . "</h1>"); ?>
				<div style="height: clamp(24px, 5vw, 40px);"></div>
				<?php while ($the_query->have_posts()) {
					$the_query->the_post();
				?>
					<div>
						<a style='font-weight:bold;' href="<?php the_permalink(); ?>"><?php echo wp_strip_all_tags(get_the_title()); ?></a>
						<div><?php echo wp_strip_all_tags(get_the_excerpt()); ?></div>
					</div>
					<div style="height: clamp(24px, 5vw, 40px);"></div>
				<?php } ?>

				<div class="archive-page__numbers archive-page__numbers--search">
					<?php the_posts_pagination(array(
						'mid_size'  => 1,
						'prev_next' => false,
					)); ?>
				</div>
				<div style="height: clamp(40px, 8vw, 80px)"></div>

			<?php } else {
			?>
				<h1 style='font-size: var(--wp--preset--font-size--huge); font-weight:bold;'>Nothing Found</h1>
				<div style="height: clamp(24px, 5vw, 40px);"></div>
				<div class="alert alert-info">
					<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
					<div style="height: clamp(40px, 8vw, 80px)"></div>
				</div>
			<?php } ?>
		</div>
	</div>

</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>