<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Hope_for_Justice_2021
 */

get_header();
$filters = $_GET['sources'];
$categories = $_GET['swp_category_limiter'];

?>

<section id="primary" class="content-area">




	<main id="main" class="site-main">
		<div class="better-grid">
			<div class="archive-page--search">
				<div style="height: clamp(40px, 8vw, 80px)"></div>


				<form id="inline-search" class="search-page__form" role="search" method="get" action="<?php echo home_url('/'); ?>">
					<label>
						<span class="screen-reader-text"><?php echo _x('Search for:', 'label') ?></span>
						<div class="search-page__bar">
							<svg class="search-page__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.5 20.5">
								<path id="Union_1" data-name="Union 1" d="M.489,20.16a1.423,1.423,0,0,1-.151-1.994L5.6,12.119A7.084,7.084,0,0,1,10.5,0a7.069,7.069,0,0,1,0,14.138,6.921,6.921,0,0,1-2.653-.526L2.463,20.006a1.391,1.391,0,0,1-1.974.154ZM4.9,7.07a5.6,5.6,0,1,0,5.6-5.656A5.634,5.634,0,0,0,4.9,7.07Z" fill="#212322"></path>
							</svg>
							<input type="search" placeholder="<?php echo esc_attr_x('Search …', 'placeholder') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>" />
						</div>

					</label>
					<div style="height: 16px"></div>
					<div class="search-page__filter-container">
						<div class="search-page__filter-button button button--thin button--drop-down">Filters
							<svg xmlns="http://www.w3.org/2000/svg" width="10.364" height="6.219" viewBox="0 0 10.364 6.219">
								<path id="Path_17236" data-name="Path 17236" d="M5.2,6.221a1.013,1.013,0,0,1-.718-.3L.3,1.734A1.016,1.016,0,0,1,1.734.3L5.2,3.768,8.676.3a1.016,1.016,0,0,1,1.437,1.437L5.923,5.923a1.013,1.013,0,0,1-.723.3Z" transform="translate(-0.046 -0.002)" fill="#fff" />
							</svg>
						</div>


						<div class="search-page__filters">
							<!-- <p>Filter by type:</p> -->
							<div class="search-page__checkboxes">
								<div class="">
									<input class="search-page__filter--all" id="source-all" type="checkbox" name="all" <?php if (!$filters && $categories !== '578') echo ' checked' ?> />
									<label for="source-all">All Results</label>
								</div>
								<div class="">
									<input class="search-page__filter" type="checkbox" id="source-post" value="post" name="sources[]" <?php if (in_array("post", $filters)) echo ' checked' ?> />
									<label for="source-post">News Posts</label>
								</div>
								<div class="">
									<input class="search-page__filter" type="checkbox" id="source-page" value="page" name="sources[]" <?php if (in_array("page", $filters)) echo ' checked' ?> />
									<label for="source-page">Pages</label>
								</div>
								<div class="">
									<input class="search-page__filter" type="checkbox" id="source-case-studies" value="578" name="swp_category_limiter" <?php if ($categories) echo ' checked' ?> />
									<label for="source-case-studies">Case studies</label>
								</div>
								<div class="">
									<input class="search-page__filter" type="checkbox" id="source-resources" value="578" name="swp_category_limiter" <?php if ($categories) echo ' checked' ?> />
									<label for="source-resources">Resources</label>
								</div>
								<div class="">
									<input class="search-page__filter" type="checkbox" id="source-publications" value="578" name="swp_category_limiter" <?php if ($categories) echo ' checked' ?> />
									<label for="source-publications">Publications</label>
								</div>


							</div>


							<button type="submit" form="inline-search" value="Submit" class="search-submit button--thin button button--spinner" />
							Apply
							</button>
						</div>
					</div>




				</form>


				<?php if (have_posts()) : ?>

					<!-- <div style="height: clamp(40px, 8vw, 80px)"></div>
					<header class="page-header">
						<h1 style="font-size: var(--wp--preset--font-size--huge); font-weight:bold;">
							<?php
							/* translators: %s: search query. */
							printf(esc_html__('Search results for: %s', 'hope-for-justice-2021'), '<span>' . get_search_query() . '</span>');
							?>
						</h1>
					</header> -->
					<!-- .page-header -->
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
