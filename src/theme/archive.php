<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<div id="primary" class="content-area archive-page">
	<main id="main" class="site-main">

		<?php if (have_posts()) : ?>



			<div style="height: clamp(40px, 8vw, 80px)"></div>
			<div class="better-grid">
				<header style="grid-column: span 12;" class="archive-header">
					<h1 style="font-size: var(--wp--preset--font-size--huge); font-weight:bold;" class="">
						<?php if (!is_category()) echo 'Posts tagged with: ' ?><?php the_archive_title(); ?></h1>
				</header><!-- .page-header -->
			</div>
			<div style="height: clamp(24px, 5vw, 40px);"></div>

			<div class="better-grid">
				<div style="grid-column: span 12; font-size:18px;" class="block-post__breadcrumbs">
					<span class="aioseo-breadcrumb">
						<a style="color:var(--black);" href="/news" title="Home">News</a>
					</span>
					<span class="aioseo-breadcrumb-separator">&nbsp;›&nbsp;</span>
					<span class="aioseo-breadcrumb">
						<a style="color:var(--black);"><?php the_archive_title(); ?></a>
					</span>
				</div>
			</div>

			<div style="height: clamp(24px, 5vw, 40px);"></div>



			<div class="better-grid post-block">
				<?php
				/* Start the Loop */
				while (have_posts()) :
					the_post(); ?>

					<?php
					//acf
					$image = get_field('focus_point_image', get_the_ID());
					$news_icon = get_field('news_icon', get_the_ID());
					$news_icon_height = get_field('news_icon_height');
					$iframe = get_field('upload_video', get_the_ID(), false);
					$vimeo = explode('/', $iframe);
					$vimeo_id = end($vimeo);

					if ($image) {
						$id = $image['id'];
						$image_src = wp_get_attachment_image_src($id, 'full');
						$image_src = $image_src[0];
					} else {
						$image_src = get_the_post_thumbnail_url();
					}

					//$date_mod = date("M j", strtotime(get_the_date()));
					$title = get_the_title();
					$link = get_the_permalink();
					$tags = get_the_tags();
					$cat = get_the_category();
					$cat_info = $cat[0];
					?>
					<div class="post-block__post post-block__post--cat-<?php echo $cat_info->slug ?>">
						<!-- image -->
						<div style="background-size:cover; background-image: url('<?php echo $image_src; ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;" class="post-block__image">
						</div>

						<a class="post-block__link <?php if ($cat_info->name == 'Videos') echo 'video-trigger'; ?>" <?php if ($cat_info->name !== 'Videos') {
																														echo 'href="' .  $link;
																													} else {
																														echo 'data-toggle="modal" data-target="#video-modal" data-src="https://player.vimeo.com/video/' . $vimeo_id;
																													} ?>"></a>

						<div class="post-block__content">
							<div style="display: inline-block;">
								<div class="post-block__date">
									<svg id="Group_7762" data-name="Group 7762" xmlns="http://www.w3.org/2000/svg" width="11.819" height="11.82" viewBox="0 0 11.819 11.82">
										<path id="Path_17202" data-name="Path 17202" d="M5.91,11.819a5.91,5.91,0,1,1,5.91-5.91,5.916,5.916,0,0,1-5.91,5.91M5.91.985A4.925,4.925,0,1,0,10.834,5.91,4.93,4.93,0,0,0,5.91.985" transform="translate(0 0)" fill="#212322" />
										<path id="Path_17203" data-name="Path 17203" d="M7.04,7.109H6.969a.4.4,0,0,1-.4-.4V3.567a.4.4,0,0,1,.4-.4H7.04a.4.4,0,0,1,.4.4V6.711a.4.4,0,0,1-.4.4" transform="translate(-1.095 -0.528)" fill="#212322" />
										<path id="Path_17204" data-name="Path 17204" d="M6.569,7.237l.089-.1a.367.367,0,0,1,.519-.021L8.949,8.754a.367.367,0,0,1,.021.518l-.091.1a.365.365,0,0,1-.517.021L6.589,7.755a.366.366,0,0,1-.02-.518" transform="translate(-1.078 -1.17)" fill="#212322" />
									</svg>

									<p><?php echo get_the_date() ?></p>
								</div>
							</div>
							<div class="post-block__title"><?php the_title() ?><span style="white-space: pre;">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span>
							</div>
						</div>
						<?php if ($tags) { ?>
							<div class="post-block__tags">
								<?php $count = 0;
								foreach ($tags as $tag) {
									if ($count < 2 && $tag->name != get_the_archive_title()) {
										$tag_link = get_tag_link($tag->term_id); ?><a class="post-block__tag" href="<?php echo $tag_link ?>"><?php echo $tag->name ?></a>
								<?php $count++;
									}
								} ?>
							</div>
						<?php } ?>
					</div>




				<?php endwhile; ?>
			</div>

		<?php

		endif;
		?>
		<div style="height: clamp(24px, 5vw, 40px);"></div>
		<div class="better-grid">
			<div style="grid-column: span 12;" class="archive-page__numbers">
				<?php the_posts_pagination(array(
					'mid_size'  => 2,
				)); ?>
			</div>
		</div>
		<div style="height: clamp(24px, 5vw, 40px);"></div>

	</main><!-- #main -->
</div><!-- #primary -->

<!--
    --
    --  video
    --
    -->
<div class="modal modal--video fade" id="video-modal" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal__dialog modal__dialog--video">
		<div class="modal__content modal__content--video video-container">
			<iframe class="video" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

			<a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--video">&times;<span class="accessibility">Close</span></a>

		</div>
	</div>
</div>

<?php
get_footer();
