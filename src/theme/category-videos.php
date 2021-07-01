<?php
get_header();
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
$category_name = $categories[0]->name;
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $args= [
    "cat" => $category_id,
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'paged' => $paged

  
  ];
  $query = null;
  $query = new WP_Query($args);


?>

<div class="archive-page">
	<div class="grid news-page__grid">
		
		<!-- archive header -->
		<div class="archive-page__header">

			<h1 class="font-fk archive-page__title title_category_<?php echo $category_id; ?>" >
				ARCHIVE
			</h1>
			
			<!-- select -->
			<select class="custom-category archive-page__select" onchange="location = this.value;">

				<option disabled="disabled">Select Category</option>
				<option value="<?php echo home_url().'/all-categories' ?>">All Categories</option>
				
				<?php
				$categories = get_categories();
				foreach($categories as $category) {
					$selected = '';
					if($category_id == $category->term_id) {
						$selected = 'selected';
					}
						echo '<option data-value="'.$category->term_id.'" value="'.home_url().'/category/'.$category->slug.'" '.$selected.'>'.$category->name.'</option>';
				}
				?>
			</select>
			<!-- <span class="icons">&#9660;</span> -->

			<!-- search -->
			<div class="archive-page__search">
				<form action="" method="POST" >
					<input type="text" name="search-posts" class="form-control search-posts " placeholder="Search...">
					<input type="hidden" name="action" value="news_search"/>
					<input type="hidden" name="category" value="" class="scategory_id" />
					<input type="hidden" name="news_nonce" value="<?php echo wp_create_nonce('news-search-nonce')?>"/>
					 <input type="hidden" name="redirect" value="<?php echo home_url().'/search-news-results/'; ?>"/>
				</form>
			</div>
		</div>

		<!-- pagination -->
		<div class="archive-page__numbers">
			<?php 

			echo paginate_links( array(
				'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'total'        => $query->max_num_pages,
				'current'      => max( 1, get_query_var( 'paged' ) ),
				'format'       => '?paged=%#%',
				'show_all'     => false,


				'mid_size'     => 2,
				'prev_next'    => false,

				'add_args'     => false,
				'add_fragment' => '',
				'type' => 'list'
			) );
			?>
		</div>
		
		<?php if( $query->have_posts() ) {?>
	   	 	
	    <div class="cards sub-grid" id="term_slug_<?php echo $category_id; ?>">
	    		
		    <?php while ($query->have_posts()) : $query->the_post(); ?>
				
				<!-- variables -->
				<?php 
					$iframe = get_field('upload_video',false, false);
					$vimeo = explode('/',$iframe);
					$viemo_id = end($vimeo);
				?>

				<div class="cards__card" >
					<a class="video-trigger" data-src="https://player.vimeo.com/video/<?php echo @$viemo_id;?>" data-toggle="modal" data-target="#video-modal">
						<div class="cards__content">
							<div class="cards__img-container">
								<img class="cards__play-symbol" src="<?php echo get_template_directory_uri() . '/assets/img/play.svg'; ?>">
							  	<img class="cards__img" src="<?php echo get_the_post_thumbnail_url(); ?>">
						  	</div>
						
						  	<div class="cards__info">
						    	<div class="cards__text">
									<p class="cards__date">
										<?php echo get_the_date(); ?>
									</p>
									<h3 class="cards__title threeLines font-canela">
										<span class="no-links"><?php the_title(); ?></span>
									</h3>
							    	<p class="cards__excerpt">
							    		<?php echo get_the_excerpt(); ?>
							    	</p>
						    	</div>
							</div>
						</div>
					</a>
				</div>

		    <?php endwhile;?>

		    
		    <!-- pagination -->
	      	<div class="archive-page__numbers">
	      		<?php 

	      		echo paginate_links( array(
	      			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
	      			'total'        => $query->max_num_pages,
	      			'current'      => max( 1, get_query_var( 'paged' ) ),
	      			'format'       => '?paged=%#%',
	      			'show_all'     => false,
	      		
	      			
	      			'mid_size'     => 2,
	      			'prev_next'    => false,
	      			
	      			'add_args'     => false,
	      			'add_fragment' => '',
	      			'type' => 'list'
	      		) );
	      		?>
	      	</div>
		     

		    <?php wp_reset_postdata(); } ?>
		</div>

	 
	</div>
</div>

<!-- 
-- 
-- video modal
-- 
--> 
<?php get_template_part(
    'partials/content',
    'modal',
    array(
        'type' => 'video',
        'id' => 'video-modal'
    )
); ?> 

<?php
get_footer();