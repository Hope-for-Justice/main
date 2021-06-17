<?php get_header(); ?>
<?php 
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
$category_name = $categories[0]->name;
	if(is_category('videos')){
		die('2121');
		get_template_part('content','yourCategory');
	}else{
		get_template_part('content','single.php');
	}

?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php  $args=array(
	'post__not_in' => array($post->ID),
	"cat" => $category_id,
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,



	);
	$query = null;
	$query = new WP_Query($args);
    ?>
			<div class="row news-page single-news-page">
			<div class="col-lg-8 col-md-12 img-features">
			<img src="<?php echo get_the_post_thumbnail_url(); ?>">
			
			<div class="container">
			<div class="row inner-row">
			<div class="col-lg-12 col-md-12 single-post-info">
				
				<p class="date_get"><?php echo get_the_date(); ?></p>
				<h2 class="single-post-head"><?php the_title(); ?><h2>
				<?php the_content(); ?>
				<div class="row  flex-column-reverse flex-sm-row">
				<div class="col-md-6">
					<div class="header__navigation">
						<a class="button button--red button--nav bold" href="<?php echo home_url().'/news-media/';?>">Back To main <br> News Page</a>
					
					</div>
				</div>
				<div class="col-md-6 ">
						<ul class="social-custm-icons social-custm-iconss text-left ">
						<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/linkedin.svg'; ?>" alt=""></a></li>
						
						<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/twitter-seeklogo.com.svg'; ?>" alt=""></a></li>
						<li><a href="#"><img src="<?php echo get_template_directory_uri().'/assets/img/fb.svg'; ?>" alt=""></a></li>
						</ul>
						<p class="share-post">Share this post</p>
				
			</div>
				</div>
			</div>

			</div>
			</div>
			</div>
			<?php endwhile; ?>
			<?php endif; ?>
			<?php 
			 if( $query->have_posts() ) { ?>
			 	
			 	<div class="col-lg-4 col-lg-4-custom col-md-6   mt-5 scategory_<?php echo $category_id; ?>" >
			 	<h2 class="category-titles"><?php echo $category_name; ?></h2>
			<?php while ($query->have_posts()) : $query->the_post(); ?>
			<?php if($category_id != 6 && $category_id != 7) { ?>
				<div class="card mt-5" >
				
				  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
				
				  <div class="card-body">
				    <div class="card-text"> 
				    	
				    	
						<p class="date-text"><?php echo get_the_date(); ?></p>
						<h3><a href="<?php the_permalink() ?>" ><?php the_title(); ?></a></h3>
				    	<p class="text-para"><?php echo get_the_excerpt(); ?></p>
				  
				    </div>
				  </div>
				</div>
			<?php } elseif($category_id == 6) { ?>
			
			<div class="card mt-5" >

				<div class="card-body">
					<div class="card-text"> 


						<p class="date-text"><?php echo get_the_date(); ?></p>
						<h3><a href="javascript:void(0)" class="no-links"><?php the_title(); ?></a></h3>
						<p class="text-para"><?php echo get_the_excerpt(); ?></p>
						<a href="<?php the_permalink() ?>" class="stretched-link"></a>
					</div>
				</div>
			</div>

			
	<?php } elseif($category_id == 7) {  ?>
			<div class="card" >
		
		  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
		
		  <div class="card-body">
			<div class="card-text"> 
				
				
				<h3><a href="<?php the_permalink() ?>" class="stretched-link"><?php the_title(); ?></a></h3>
				<p class="date-text"><?php echo get_the_date(); ?></p>
		  
			</div>
		  </div>
		</div>
      	
       
       
      
     
       <?php
 }
      endwhile;
      ?>
      		</div>
<?php } 
      ?>

			
		
<?php get_sidebar(); ?>
<?php get_footer(); ?>