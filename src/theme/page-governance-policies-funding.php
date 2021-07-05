<?php
/**
 * Template Name: The Governance template
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main" role="main">
<?php 
global $post;


?>
	
	<div class="grid">
	<?php
	$terms = get_terms( [
		'taxonomy' => 'categories',
		'hide_empty' => false,
	]);
	$cat_order = [
		'policies-documents', 
		'accreditations', 
		'uk-financial-reports', 
		'us-financial-reports',
		'annual-reports'
	];
	usort($terms, function ($a, $b) use ($cat_order) {
		$cat_a = array_search($a->slug, $cat_order);
		$cat_b = array_search($b->slug, $cat_order);
			return $cat_a - $cat_b;
	});

	?>

		<div class="drag-cards gov_pol_fun" id="dragCards">
			<div class="custom-container">
				
					<div class="the_content_post">
						<h1 class="gpf_main_heading"><?php echo $post->post_title;?></h1>
						<?php 
						$post_content = apply_filters('the_content',$post->post_content);
						echo $post_content;
						?>
					</div>
				
			</div>
			<?php foreach($terms as $index => $term) { ?>
				<div class="custom-container">
				
						<h2 class="custom_heading_text text-left"><?php echo $term->name; ?></h2>
					
				</div>
				<?php 
				$posts_arr = get_posts(
					[
						'posts_per_page' => -1,
						'post_type' => 'gov_pol_fund',
						'tax_query' => array(
							[
								'taxonomy' => 'categories',
								'field' => 'term_id',
								'terms' => $term->term_id,
							]
						)
					]
				);
				?>
				
				<div class="drag-cards__inner pdocument_<?php echo $index;?>">
				<?php 
				foreach($posts_arr as $arr) {
				?>
					<?php if($term->slug == 'policies-documents') { ?>

						<div class="drag-cards__card">
						
							<p class="drag-cards__card-number font-canela card_tag_line">Policies & documents</p>
							
					
							<h3 class="drag-cards__card-title font-fk"><?php echo $arr->post_title; ?></h3>
							<div class="freedom-wall__button">
								<a href="<?php echo get_field('upload_pdf',$arr->ID); ?>" class="button button--black" target="_blank">
									<div class="button__inner">
										<div class="button__text bold">VIEW DOCUMENT</div>
									</div>
								</a>
							</div>

							
						</div>
					<?php } elseif($term->slug == 'accreditations') { ?>
						<?php
						$thumbnail = wp_get_attachment_url( get_post_thumbnail_id($arr->ID) ); 
						?>
						<div class="drag-cards__card custom_content">
							<p class="drag-cards__card-number custom_image"><img src="<?php echo $thumbnail; ?>"></p>
							<?php 
							$content = apply_filters('the_content',$arr->post_content);
							?>
							<?php echo $content; ?>
							<a href="<?php echo get_field('external_link',$arr->ID); ?>" class="link_next" target="_blank">Learn more about the <?php echo strtolower($arr->post_title);?></a>
						</div>
					<?php } elseif($term->slug == 'uk-financial-reports') { ?>
						<div class="drag-cards__card">
						
							<p class="drag-cards__card-number font-canela card_tag_line"><?php echo get_field('general_text',$arr->ID); ?></p>
							
					
							<h3 class="drag-cards__card-title font-fk"><?php echo $arr->post_title; ?></h3>
							<div class="freedom-wall__button">
								<a href="<?php echo get_field('upload_pdf',$arr->ID); ?>" class="button button--black" target="_blank">
									<div class="button__inner">
										<div class="button__text bold">VIEW REPORT</div>
									</div>
								</a>
							</div>

							
						</div>
					<?php } elseif($term->slug == 'us-financial-reports') { ?>
						<div class="drag-cards__card">
						
							<p class="drag-cards__card-number font-canela card_tag_line"><?php echo get_field('general_text',$arr->ID); ?></p>
							
					
							<h3 class="drag-cards__card-title font-fk"><?php echo $arr->post_title; ?></h3>
							<div class="freedom-wall__button">
								<a href="<?php echo get_field('upload_pdf',$arr->ID); ?>" class="button button--black" target="_blank">
									<div class="button__inner">
										<div class="button__text bold">VIEW REPORT</div>
									</div>
								</a>
							</div>

							
						</div>
					<?php } elseif($term->slug == 'annual-reports') { ?>
						<div class="drag-cards__card">
						
							<p class="drag-cards__card-number font-canela card_tag_line"><?php echo get_field('general_text',$arr->ID); ?></p>
							
					
							<h3 class="drag-cards__card-title font-fk"><?php echo $arr->post_title; ?></h3>
							<div class="freedom-wall__button">
								<a href="<?php echo get_field('upload_pdf',$arr->ID); ?>" class="button button--black" target="_blank">
									<div class="button__inner">
										<div class="button__text bold">VIEW REPORT</div>
									</div>
								</a>
							</div>

							
						</div>
					<?php } ?>
					
			<?php } ?>
			</div>
			<?php if($term->slug != 'policies-documents') { ?>
			<div class="drag-cards__dots dots">
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
			</div>
			<?php } ?>
			<?php } ?>

			
		</div>

	

	</div> <!-- /grid -->



</main>

<?php get_footer(); ?>