<?php
/**
 * Template Name: News Categories
 */

get_header();

?>

<div class="container news-page" id="news-page">
	<div class="row align-items-center">
		<div class="col-sm-12 col-news">
		<ul class="social-custm-icons text-right social-custm-icons-small">
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/linkedin.svg'; ?>" alt=""></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/instagram.svg'; ?>" alt=""></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/twitter-seeklogo.com.svg'; ?>" alt=""></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/fb.svg'; ?>" alt=""></a></li>
		</ul>
	</div>
		<div class="col-md-6 col-sm-12 col-news">
			<h1 class="news-page-title"><?php echo strtoupper(get_the_title()); ?></h1>

		</div>
		<div class="col-md-6 col-sm-12 col-news">
		<ul class="social-custm-icons social-custm-icons-hide text-right">
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/linkedin.svg'; ?>" alt=""></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/instagram.svg'; ?>" alt=""></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/twitter-seeklogo.com.svg'; ?>" alt=""></a></li>
			<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/fb.svg'; ?>" alt=""></a></li>
		</ul>
		<p class="text-right contact-press"><span >Contact Press:</span> press@hopeforjustice.org</p>

		</div>
	</div>
	
	<?php
	$top_category = get_category(4);

    $args=array(
      "cat" => $top_category->term_id,
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 9,

    
      );
    $query = null;
    $query = new WP_Query($args);
    if( $query->have_posts() ) {
    	?>
    	<div class="row" >
    		<div class="col-md-12  mb-3 first-one col-news">
    			<h2 class="category-titles title_category_<?php echo $top_category->term_id; ?>" >
    				<?php echo $top_category->name; ?>
    			</h2>
    		</div>
    	</div>
    	<div class="row" id="term_slug_<?php echo $top_category->term_id; ?>">
	<?php 

      while ($query->have_posts()) : $query->the_post(); ?>
	<div class="col-lg-4 col-md-6 mb-5 col-news category_<?php echo $top_category->term_id; ?>" >

		<div class="card" >
		
		  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
		
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

      	
       
       
      
     
       <?php
      endwhile;
      wp_reset_postdata();
    } ?>
	</div>
    	<div class="row">
    	<div class="col-md-12 text-center col-news">
    		
    		
				<div class="drag-cards__button">
					<a href="javascript:void(0)" class="button button--white more_posts" data-term="<?php echo $top_category->term_id; ?>" data-href="<?php echo home_url().'/category/top_news/';?>">
						<div class="button__inner">
							<div class="button__text bold">See more</div>
						</div>
					</a>
				</div>

    	
    	</div>
    	</div>


<?php 
wp_reset_query();  // Restore global post data stomped by the_post().
?>
	<?php
	$video_category = get_category(5);

    $args=array(
      "cat" => $video_category->term_id,
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 9,

    
      );
    $query = null;
    $query = new WP_Query($args);
    if( $query->have_posts() ) {
    	?>
    	<div class="row" >
    		<div class="col-md-12 mt-5 mb-3 col-news">
    			<h2 class="category-titles title_category_<?php echo $video_category->term_id; ?>" >
    				<?php echo $video_category->name; ?>
    			</h2>
    		</div>
    	</div>
    	<div class="row" id="term_slug_<?php echo $video_category->term_id; ?>">
	<?php 

      while ($query->have_posts()) : $query->the_post(); ?>
	<div class="col-lg-4 col-md-6 mb-5 col-news category_<?php echo $video_category->term_id; ?>" >
		<div class="card" >
			<?php 
			$iframe = get_field('upload_video',false, false);

			$vimeo = explode('/',$iframe);
			$viemo_id = end($vimeo);
			
			?>
		<img src="<?php echo get_template_directory_uri() . '/assets/img/play.svg'; ?>"  class="play-button-news" data-src="https://player.vimeo.com/video/<?php echo @$viemo_id;?>" data-id="#video-modal-<?php echo get_the_id(); ?>">
		
		  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid play-button-newss" data-src="https://player.vimeo.com/video/<?php echo @$viemo_id;?>" data-id="#video-modal-<?php echo get_the_id(); ?>">
		
		  <div class="card-body">
		    <div class="card-text"> 
		    	
		    	
				<p class="date-text"><?php echo get_the_date(); ?></p>
				<h3><a href="javascript:void(0)" class="no-links"><?php the_title(); ?></a></h3>
		    	<p class="text-para"><?php echo get_the_excerpt(); ?></p>
		    	  
		    
		    </div>
		  </div>
		</div>
	</div>

      	
       
       
      
     
       <?php
      endwhile;
      wp_reset_postdata();
    } ?>
	</div>
    	<div class="row">
    	<div class="col-md-12 text-center col-news">
    		
    		<div class="drag-cards__button">
						<a href="javascript:void(0)" class="button button--white more_posts" data-term="<?php echo $video_category->term_id; ?>" data-href="<?php echo home_url().'/category/videos/';?>">
						<div class="button__inner">
							<div class="button__text bold">See more</div>
						</div>
					</a>
				</div>
    		
    	
    	</div>
    	</div>


<?php 
wp_reset_query();  // Restore global post data stomped by the_post().
?>
<?php
	$headline_category = get_category(6);

    $args=array(
      "cat" => $headline_category->term_id,
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 9,

    
      );
    $query = null;
    $query = new WP_Query($args);
    if( $query->have_posts() ) {

    	?>
    	<div class="row" >
    		<div class="col-md-12 mt-5 mb-3 col-news">
    			<h2 class="category-titles title_category_<?php echo $headline_category->term_id; ?>" >
    				<?php echo $headline_category->name; ?>
    			</h2>
    		</div>
    	</div>
    	<div class="row" id="term_slug_<?php echo $headline_category->term_id; ?>">
	
	<?php 

      while ($query->have_posts()) : $query->the_post(); ?>
      	<?php  $external_link = get_field('external_news_link',get_the_ID()); ?>
      	<div class="col-lg-4 col-md-6 mb-5 col-news category_<?php echo $headline_category->term_id; ?>" >
					<div class="mb-5 category_<?php echo $headline_category->term_id; ?>" >
						<div class="card" >
						
						  <div class="card-body">
						    <div class="card-text"> 
						    	
						    	
								<p class="date-text"><?php echo get_the_date(); ?></p>
								<h3><a href="javascript:void(0)" class="no-links"><?php the_title(); ?></a></h3>
						    	<p class="text-para"><?php echo get_the_excerpt(); ?></p>
						      <a href="<?php echo  $external_link;  ?>" class="stretched-link" target="_blank"></a>
						    </div>
						  </div>
						</div>
					</div>

      	</div>
       
       
      
     
       <?php
      endwhile;
      wp_reset_postdata();
    } ?>

	</div>

	   	<div class="row">
    	<div class="col-md-12 text-center col-news">
    		
    		<div class="drag-cards__button">
					<a href="javascript:void(0)" class="button button--white more_posts" data-term="<?php echo $headline_category->term_id; ?>" data-href="<?php echo home_url().'/category/in_the_headlines/';?>">
						<div class="button__inner">
							<div class="button__text bold">See more</div>
						</div>
					</a>
				</div>
    		
    	
    	</div>
    	</div>
    	


<?php 
wp_reset_query();  // Restore global post data stomped by the_post().
?>
<?php
	$blog_category = get_category(7);

    $args=array(
      "cat" => $blog_category->term_id,
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 9,

    
      );
    $query = null;
    $query = new WP_Query($args);
    if( $query->have_posts() ) {
    	?>
    	<div class="row" >
    		<div class="col-md-12 mt-5 mb-3 col-news">
    			<h2 class="category-titles title_category_<?php echo $blog_category->term_id; ?>" >
    				<?php echo $blog_category->name; ?>
    			</h2>
    		</div>
    	</div>
    	<div class="row" id="term_slug_<?php echo $blog_category->term_id; ?>">
	<?php 

      while ($query->have_posts()) : $query->the_post(); ?>
	<div class="col-lg-4 col-md-6 col-news mb-5 category_<?php echo $blog_category->term_id; ?>" >
		<div class="card" >
		
		  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
	
		  <div class="card-body">
		    <div class="card-text"> 
		    	
		    	

				<h3><a href="javascript:void(0)" class="no-links"><?php the_title(); ?></a></h3>
				<p class="date-text"><?php echo get_the_date(); ?></p>
		    <a href="<?php the_permalink() ?>" class="stretched-link"></a>
		    </div>
		  </div>
		</div>
	</div>

      	
       
       
      
     
       <?php
      endwhile;
      wp_reset_postdata();
    } ?>
	</div>
    	<div class="row">
    	<div class="col-md-12 text-center col-news">
    		
    		<div class="drag-cards__button">
						<a href="javascript:void(0)" class="button button--white more_posts" data-term="<?php echo $headline_category->term_id; ?>" data-href="<?php echo home_url().'/category/blogs_and_opinion_editorials/';?>">
						<div class="button__inner">
							<div class="button__text bold">See more</div>
						</div>
					</a>
				</div>
    		
    	
    	</div>
    	</div>


<?php 
wp_reset_query();  // Restore global post data stomped by the_post().
?>
</div>
<?php
get_footer();