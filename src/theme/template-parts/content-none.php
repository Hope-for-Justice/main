<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hope_for_Justice_2020
 */

?>

<section class="no-results not-found">
	<div style="height: clamp(40px, 8vw, 80px)"></div>
	<header class="page-header">
		<h1 style="font-size: var(--wp--preset--font-size--extra-large); font-weight:bold; margin-bottom:0;"><?php esc_html_e('Nothing Found', 'hope-for-justice-2019'); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if (is_home() && current_user_can('publish_posts')) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'hope-for-justice-2019'),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url(admin_url('post-new.php'))
			);

		elseif (is_search()) :
		?>

			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hope-for-justice-2019'); ?></p>
		<?php

		else :
		?>

			<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hope-for-justice-2019'); ?></p>
		<?php


		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->