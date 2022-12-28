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

<?php
$s = get_search_query();
$args = array(
	's' => $s
);
// The Query
$the_query = new WP_Query($args);
if ($the_query->have_posts()) {
	_e("<h2 style='font-weight:bold;color:#000'>Search Results for: " . get_query_var('s') . "</h2>");
	while ($the_query->have_posts()) {
		$the_query->the_post();
?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php echo strip_tags(get_the_title()); ?></a>
		</li>
	<?php
	}
} else {
	?>
	<h2 style='font-weight:bold;color:#000'>Nothing Found</h2>
	<div class="alert alert-info">
		<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
	</div>
<?php } ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>