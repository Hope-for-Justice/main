<?php

/**
 * Template Name: All Categories
 */

get_header();

  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $args= [
  	'category__not_in' => array( 6 ),
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'paged' => $paged

  
  ];
  $query = null;
  $query = new WP_Query($args);


?>

<div class="container news-page">
	<div class="row align-items-center" >
		<div class="col-md-4 mt-5 mb-3 col-news">
			<h1 class="archive_example title_category_4>" >
				ARCHIVE EXAMPLE
			</h1>
		</div>
		<div class="col-md-4 mt-5 mb-3 col-news">
			<select class="custom-category" onchange="location = this.value;">

				<option disabled="disabled">Select Category</option>
				<option value="<?php echo home_url().'/all-categories' ?>">All Categories</option>
				<?php
				$categories = get_categories();
				foreach($categories as $category) {
					if($category->term_id != '6') {
					$selected = '';
					if($category_id == $category->term_id) {
						$selected = 'selected';
					}
						echo '<option data-value="'.$category->term_id.'" value="'.home_url().'/category/'.$category->slug.'" '.$selected.'>'.$category->name.'</option>';
					}
					
				}
				?>
		</select>
		<span class="icons">&#9660;</span>
		</div>
		<div class="col-md-4 mt-5 mb-3 col-news">
			<form action="" method="POST" >
				<input type="text" name="search-posts" class="form-control search-posts " placeholder="Search...">
				<input type="hidden" name="action" value="news_search"/>
				<input type="hidden" name="category" value="" class="scategory_id" />
				<input type="hidden" name="news_nonce" value="<?php echo wp_create_nonce('news-search-nonce')?>"/>
				 <input type="hidden" name="redirect" value="<?php echo home_url().'/search-news-results/'; ?>"/>
			</form>
		</div>
	</div>
	<div class="row">
	<div class="col-md-12 col-news">
		<div class="pagination mb-5">
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
	</div>
	</div>
		<?php
  	

    
    if( $query->have_posts() ) {
    	?>
    	
    
    	<div class="row" id="term_slug_4 ">
    		<?php 

      while ($query->have_posts()) : $query->the_post(); ?>
      	<?php 
      	$categories = get_the_terms( $query->ID, 'category',true );


      	$category_id = $categories[0]->term_id; ?>

      	    <!-- 

			if the card is NOT a video show with the below markup

      		-->
      
			<div class="col-lg-4 col-news col-md-6 mb-5 category_4 category_all4" >
				<a href="<?php the_permalink() ?>">
					<div class="card" >
					
					  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
					
					  <div class="card-body">
					    <div class="card-text"> 
					    	
					    	
							<p class="date-text"><?php echo get_the_date(); ?></p>
							<h3><span ><?php the_title(); ?></span></h3>
					    	<p class="text-para"><?php echo get_the_excerpt(); ?></p>
					  
					    </div>
					  </div>
					</div>
				</a>
			</div>

      		<!-- 

			Else if the card is a video show with the below markup

			basically so we dont have to have inner posts for videos they can just bring up the modal like they do on the main news-media page

      		-->


				<!-- <?php 
					//$iframe = get_field('upload_video',false, false);
					//$vimeo = explode('/',$iframe);
					//$viemo_id = end($vimeo);
				?> -->

					<!-- <div class="cards__card" >
					<a class="video-trigger" data-src="https://player.vimeo.com/video/<?php //echo @$viemo_id;?>" data-toggle="modal" data-target="#video-modal">
						<div class="cards__content">
							<div class="cards__img-container">
								<img class="cards__play-symbol" src="<?php //echo get_template_directory_uri() . '/assets/img/play.svg'; ?>">
							  	<img class="cards__img" src="<?php //echo get_the_post_thumbnail_url(); ?>">
						  	</div>
						
						  	<div class="cards__info">
						    	<div class="cards__text">
									<p class="cards__date">
										<?php //echo get_the_date(); ?>
									</p>
									<h3 class="cards__title threeLines font-canela">
										<span class="no-links"><?php //the_title(); ?></span>
									</h3>
							    	<p class="cards__excerpt">
							    		<?php //echo get_the_excerpt(); ?>
							    	</p>
						    	</div>
							</div>
						</div>
					</a>
				</div> -->
     
       <?php
      endwhile;
      ?>
      <div class="col-md-12 col-news">
      	<div class="pagination">
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
      </div>
      <?php      
      wp_reset_postdata();
    } ?>
	</div>

 

</div>
<?php
get_footer();