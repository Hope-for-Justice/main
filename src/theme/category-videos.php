<?php

$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
$category_name = $categories[0]->name;


get_header();

function custom_excerpt_length( $length ) {
        return 15;
    }
    add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
?>

<div class="container">

	
		<?php


    $args=array(
      "cat" => $category_id,
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => -1,

    
      );
    $query = null;
    $query = new WP_Query($args);
    if( $query->have_posts() ) {
    	?>
    	<div class="row" >
    		<div class="col-md-12 mt-5 mb-3">
    			<h2 class="category-titles title_category_<?php echo $category_id; ?>" >
    				<?php echo $category_name; ?>
    			</h2>
    		</div>
    	</div>
    	<div class="row" id="term_slug_<?php echo $category_id; ?>">
	<?php 

      while ($query->have_posts()) : $query->the_post(); ?>
	<div class="col-lg-4 col-md-6 mb-5 category_<?php echo $category_id; ?>" >
		<div class="card" >
		<img src="<?php echo get_template_directory_uri() . '/assets/img/play.svg'; ?>"  class="play-button">
		  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
		
		  <div class="card-body">
		    <div class="card-text"> 
		    	
		    	
				<span class="date-text"><?php echo get_the_date(); ?></span>
				<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		    	<p><?php echo get_the_excerpt(); ?></p>
		  
		    </div>
		  </div>
		</div>
	</div>

      	
       
       
      
     
       <?php
      endwhile;
      wp_reset_postdata();
    } ?>
	</div>
    <!-- 	<div class="row">
    	<div class="col-md-12 text-center">
    		<button  type="button" class="more_posts" data-term="<?php echo $category_id; ?>" class="btn btn btn-light btn-lg ">See More</button>
    	</div>
    	</div> -->

  <?php 

wp_reset_query();  // Restore global post data stomped by the_post().
?>
	
</div>
<?php
get_footer();