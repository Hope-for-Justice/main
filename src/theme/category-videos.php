<?php
get_header();
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
$category_name = $categories[0]->name;

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
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

<div class="container">

	<div class="row align-items-center" >
		<div class="col-md-4 mt-5 mb-3">
			<h1 class="archive_example title_category_<?php echo $category_id; ?>" >
				ARCHIVE EXAMPLE
			</h1>
		</div>
		<div class="col-md-4 mt-5 mb-3">
			<select  onchange="location = this.value;">
				<option value="">Select Category</option>
				<?php
				$categories = get_categories();
				foreach($categories as $category) {
					if($category->slug != 'in_the_headlines') {
						echo '<option value="'.home_url().'/category/'.$category->slug.'">'.$category->name.'</option>';
					}
				}
				?>
			</select>
			<span class="icons">&#9660;</span>
		</div>
		<div class="col-md-4 mt-5 mb-3">
			<input type="text" name="" class="form-control search-posts" placeholder="Search...">
		</div>
	</div>
	<div class="row">
	<div class="col-md-12">
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

	
<?php if( $query->have_posts() ) {
		?>
		
		<div class="row" id="term_slug_<?php echo $category_id; ?>">
	<?php 

	  while ($query->have_posts()) : $query->the_post(); ?>
	<div class="col-lg-4 col-md-6 mb-5 category_<?php echo $category_id; ?>" >
		<div class="card" >
		<img src="<?php echo get_template_directory_uri() . '/assets/img/play.svg'; ?>"  class="play-button">
		  <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid">
		
		  <div class="card-body">
			<div class="card-text"> 
				
				
				<p class="date-text"><?php echo get_the_date(); ?></p>
				<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<p class="text-para"><?php echo get_the_excerpt(); ?></p>
		  
			</div>
		  </div>
		</div>
	</div>

		
	   
	   
	  
	 
	   <?php
	  endwhile;
	  ?>
	    <div class="col-md-12">
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