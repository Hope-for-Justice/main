<?php
/**
 * Template Name: The Governance template
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main gpf" role="main">

<?php global $post; ?>
	
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

		<div class="gpf__header">
			<!-- Heading and description -->
			<h1 class="font-fk">
				<?php echo $post->post_title;?>
			</h1>
			<?php 
			$post_content = apply_filters('the_content',$post->post_content);
			echo $post_content;
			?>
		</div>


		<?php foreach($terms as $index => $term) { ?>

				<h2 class="gpf-category-title font-canela"><?php echo $term->name; ?></h2>

				<?php if($term->slug == 'policies-documents') { ?>
					<div class="sub-grid cards gpf__cards">
				<?php } else { ?>
					<div class="drag-cards">
						<div class="drag-cards__inner">
				<?php } ?>

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
				
				<?php 
				foreach($posts_arr as $arr) {
					if(get_field('choose_between_field',$arr->ID) == 'updf') {
						$field = get_field('upload_pdf',$arr->ID); 
					} elseif(get_field('choose_between_field',$arr->ID) == 'elink') { 
						$field = get_field('external_link',$arr->ID); 
					}	
				?>

					
						<?php if($term->slug == 'policies-documents') { ?>

							<div class="cards__card">
								<div class="gpf__cards-inner">
									<p class="gpf__cards-category">Policies & documents</p>
							
									<h3 class="drag-cards__card-title gpf__cards-title font-fk">
										<?php echo $arr->post_title; ?>		
									</h3>
									
									<div class="gpf__cards-button-container">
										<a href="<?php echo @$field; ?>" class="button button--black" target="_blank">
											<div class="button__inner">
												<div class="button__text bold">		VIEW DOCUMENT</div>
											</div>
										</a>
									</div>
								</div>
							</div>

						<?php } elseif($term->slug == 'accreditations') { ?>
							
							<?php
							$thumbnail = wp_get_attachment_url( get_post_thumbnail_id($arr->ID) ); 
							?>
							<div class="drag-cards__card gpf__accred-card">
								<div class="gpf__accred-img">
									<img src="<?php echo $thumbnail; ?>">
								</div>
								<?php 
								$content = apply_filters('the_content',$arr->post_content);
								?>
								<div class="line"></div>
								<div class="gpf__accred-content">
									<?php echo $content; ?>
								</div>
								<a href="<?php echo get_field('external_link',$arr->ID); ?>" class="gfp__accred-link-text" target="_blank">Learn more</a>
							</div>

						<?php } elseif($term->slug == 'uk-financial-reports') { ?>
							<div class="drag-cards__card gpf__drag-cards">
								<div class="gpf__cards-inner">

									<p class="gpf__cards-category"><?php echo get_field('general_text',$arr->ID); ?></p>
									
									<h3 class="drag-cards__card-title gpf__cards-title font-fk">
										<?php echo $arr->post_title; ?>	
									</h3>

									<div class="gpf__cards-button-container">
										<a href="<?php echo get_field('upload_pdf',$arr->ID); ?>" class="button button--black" target="_blank">
											<div class="button__inner">
												<div class="button__text bold">VIEW REPORT</div>
											</div>
										</a>
									</div>

								</div>
							</div>
						<?php } elseif($term->slug == 'us-financial-reports') { ?>
							<div class="drag-cards__card gpf__drag-cards">
								<div class="gpf__cards-inner">

									<p class="gpf__cards-category">
										<?php echo get_field('general_text',$arr->ID); ?>	
									</p>

									<h3 class="drag-cards__card-title font-fk gpf__cards-title">
										<?php echo $arr->post_title; ?>	
									</h3>

									<div class="gpf__cards-button-container">
										<a href="<?php echo @$field; ?>" class="button button--black" target="_blank">
											<div class="button__inner">
												<div class="button__text bold">VIEW REPORT</div>
											</div>
										</a>
									</div>
								</div>
							</div>
						<?php } elseif($term->slug == 'annual-reports') { ?>
							<div class="drag-cards__card gpf__drag-cards">
								<div class="gpf__cards-inner">
									<p class="gpf__cards-category">
										<?php echo get_field('general_text',$arr->ID); ?>	
									</p>

									<h3 class="drag-cards__card-title font-fk gpf__cards-title">
										<?php echo $arr->post_title; ?>	
									</h3>

									<div class="gpf__cards-button-container">
										<a href="<?php echo @$field; ?>" class="button button--black" target="_blank">
											<div class="button__inner">
												<div class="button__text bold">VIEW REPORT</div>
											</div>
										</a>
									</div>
								</div>
							</div>
					<?php } ?>

					
				<?php } ?>

				<?php if($term->slug != 'policies-documents') { ?>
					</div>
					<div class="drag-cards__dots dots">
						<div class="dots__dot"></div>
						<div class="dots__dot"></div>
						<div class="dots__dot"></div>
						<div class="dots__dot"></div>
					</div>
				<?php } ?>
				</div> <!-- / cards or / drag cards -->  

		<?php } ?>



	</div> <!-- / grid -->


</main>

<?php get_footer(); ?>