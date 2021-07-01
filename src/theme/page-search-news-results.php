<?php

get_header();
	$category_idd = $_GET['category'];
	$extra_cat = '';
	if(isset($category_idd) && !empty($category_idd)) {
		$args = [
  	"cat" => $category_idd
  	];
	}
	
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $args= [
  	
    'post_type' => 'post',
   	
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'paged' => $paged,
    'search_news_title' => $_GET['search'],
  
  ];

 
  add_filter('posts_where', 'title_filter', 10, 2);
  $query = new WP_Query($args);
 
  remove_filter('posts_where', 'title_filter', 10, 2);
  ?>

<div class="container news-page">
	<div class="row align-items-center" >
		<div class="col-md-4 mt-5 mb-3 col-news">
			<h1 class="archive_example title_category_7" >
				SEARCH RESULTS
			</h1>
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
    	
    
    	<div class="row" id="term_slug_4">
    		<?php 

      while ($query->have_posts()) : $query->the_post(); ?>
      		<?php 
      	$categories = get_the_terms( $query->ID, 'category',true );
      	 if(isset($category_idd) && !empty($category_idd)) {
      	 	$cattt = $categories[0]->term_id;
      	} else {
      		$cattt = 4;
      		$extra_cat = 'category_all4';
      	}?>

      	<?php $category_id = $categories[0]->term_id; ?>
      	
      	<?php if($category_id  == '4') {?>
				<div class="col-lg-4 col-news col-md-6 mb-5 category_<?php echo $cattt; ?> <?php echo $extra_cat; ?>" >
					<div class="card" >
					
					  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
					
					  <div class="card-body">
					    <div class="card-text"> 
					    	
					    	
							<p class="date-text"><?php echo get_the_date(); ?></p>
							<h3><a href="<?php the_permalink() ?>" class="stretched-link"><?php the_title(); ?></a></h3>
					    	<p class="text-para"><?php echo get_the_excerpt(); ?></p>
					  
					    </div>
					  </div>
					</div>
				</div>
			<?php } elseif($category_id  == '5') {?>

				<div class="col-lg-4 col-news col-md-6 mb-5 category_<?php echo $cattt; ?> <?php echo $extra_cat; ?>" >
					<div class="card" >
						<img src="<?php echo get_template_directory_uri() . '/assets/img/play.svg'; ?>"  class="play-button">
						<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">

						<div class="card-body">
							<div class="card-text"> 


								<p class="date-text"><?php echo get_the_date(); ?></p>
								<h3><a href="<?php the_permalink() ?>" class="stretched-link"><?php the_title(); ?></a></h3>
								<p class="text-para"><?php echo get_the_excerpt(); ?></p>

							</div>
						</div>
					</div>
				</div>
       
       
      
     <?php } 

     elseif($category_id  == '6') { ?>
     	<?php  if(isset($category_idd) && !empty($category_idd)) { ?>
     	<div class="col-lg-4 col-md-6 mb-5 col-news category_<?php echo $category_id; ?>" >
			<div class="mb-5 category_<?php echo $category_id; ?>" >
				<div class="card" >

					<div class="card-body">
						<div class="card-text"> 


							<p class="date-text"><?php echo get_the_date(); ?></p>
							<h3><a href="javascript:void(0)" class="no-links"><?php the_title(); ?></a></h3>
							<p class="text-para"><?php echo get_the_excerpt(); ?></p>
							<a href="<?php the_permalink() ?>" class="stretched-link"></a>
						</div>
					</div>
				</div>
			</div>

		</div>

<?php } ?>
     	 <?php } elseif($category_id  == '7') { ?>
     	 	<div class="col-lg-4 col-news col-md-6 mb-5 category_<?php echo $cattt; ?> <?php echo $extra_cat; ?>" >
     	 		<div class="card" >

     	 			<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">

     	 			<div class="card-body">
     	 				<div class="card-text"> 


     	 					<h3><a href="<?php the_permalink() ?>" class="stretched-link"><?php the_title(); ?></a></h3>
     	 					<p class="date-text"><?php echo get_the_date(); ?></p>

     	 				</div>
     	 			</div>
     	 		</div>
     	 	</div>

     	 	 <?php } ?>
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
    } else {
    	echo '<h1>No Post Found</h1>';
    }?>
	</div>

 

</div>
<?php
get_footer();