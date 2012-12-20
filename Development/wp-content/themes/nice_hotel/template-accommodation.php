<?php 

/* 
Template Name: Accommodation
*/ 

// Fetch options stored in $data
global $data;

?>

<?php get_header(); ?>

	<?php //Display Page Header
		global $wp_query;
		$postid = $wp_query->post->ID;
		echo page_header( get_post_meta($postid, 'qns_page_header_image', true) );
		wp_reset_query();
	?>
	
	<!-- BEGIN .section -->
	<div class="section accommodation-page page-full clearfix">
		
		<h2 class="page-title page-title-full"><?php the_title(); ?></h2>
				
		<!-- BEGIN .section -->
		<div class="section clearfix">
			
			<?php if( get_the_content() ) {
				echo '<div class="page-content page-content-full-border">';
				the_content(); 
				echo '</div>';
			} ?>
			
			<?php
				
				if( $data['accom_items_per_page'] ) { 
					$accommodation_perpage = $data['accom_items_per_page'];
				}
				else {
					$accommodation_perpage = '10';
				}
			
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
				query_posts( "post_type=accommodation&posts_per_page=$accommodation_perpage&paged=$paged" );
				
				$count = 0;
				
			   	if( have_posts() ) :
				while( have_posts() ) : the_post(); ?>

					<?php			
						// Get accommodation date
						$accommodation_featured = get_post_meta($post->ID, $prefix.'accommodation_featured', true);	
					
						if ( $accommodation_featured == 'on' ) {
							$featured_wrapper = 'featured-wrapper';
							$featured_bottom = '<div class="featured-bottom"></div>';
						}
						
						else {
							$featured_wrapper = '';
							$featured_bottom = '';
						}
						
						// Get Currency Unit
						if ( $data['currency_unit'] !== '' ) {
							$currency_unit = $data['currency_unit'];
						}

						else {
							$currency_unit = '$';
						}

						// Get Acommodation Data
						if (get_post_meta($post->ID, 'qns_accommodation_price', true) == '') {
							$accommodation_price = '0';
						} 
						else {
							$accommodation_price = get_post_meta($post->ID, 'qns_accommodation_price', true);
						}
						
					?>

					<div class="one-third-full <?php echo $featured_wrapper; ?>">

						<p><div class="block-img1"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
							<?php // Get the Thumbnail URL
								$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'accommodation-thumb' );
								echo '<img src="' . $src[0] . '" alt="" />';
							?>
	
							<?php if ( $data['cottage_price_display'] ) { ?>
								<div class="accommodation_img_price"><?php echo $currency_unit.$accommodation_price; ?><div class="corner-right-small"></div></div>
							<?php } ?>
	
						</a></div></p>
	
						<h3 class="title1"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="title-end"></span></h3>	
						<?php the_excerpt(); ?>
						
						<?php echo $featured_bottom; ?>
						
					</div>
					
					<?php
						$count++;
						
						// Clear floats every 3 lines
						if ($count % 3 == 0) {	
							echo '<div class="clearboth"></div>';
							// Add a <hr> after every 3 items except ones on the last line
							if ($count % 6 != 0) {
								echo '<hr>';
							}
						}
								
					?>

					<?php endwhile; else : ?>
						
						<div class="page-content page-content-full page-padding"><p><?php _e('No Accommodation has been added yet','qns'); ?></p></div>
					
					<?php endif; ?>

					<?php // Include Pagination feature
						load_template( get_template_directory() . '/includes/pagination.php' );
					?>

		<!-- END .section -->
		</div>
				
		<hr>

	<!-- END .section -->
	</div>

<?php get_footer(); ?>