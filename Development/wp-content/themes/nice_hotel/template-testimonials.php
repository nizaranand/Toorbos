<?php 

/* 
Template Name: Testimonials
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
	<div class="section clearfix">
		
		<!-- BEGIN .main-content -->
		<div class="<?php echo sidebar_position('primary-content'); ?>">
			
			<h2 class="page-title"><?php the_title(); ?></h2>
				
			<!-- BEGIN .page-content -->
			<div class="page-content testimonial-full">
				
				<?php the_content(); ?>
				
				<?php
					
					if( $data['items_per_page'] ) { 
						$testimonial_perpage = $data['items_per_page'];
					}
					else {
						$testimonial_perpage = '10';
					}
				
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
					query_posts( "post_type=testimonial&posts_per_page=$testimonial_perpage&paged=$paged" );

			    	if( have_posts() ) :
					while( have_posts() ) : the_post(); ?>

						<?php	
							// Get testimonial date
							$testimonial_guest = get_post_meta($post->ID, $prefix.'testimonial_guest', true);
							$testimonial_room = get_post_meta($post->ID, $prefix.'testimonial_room', true);			
						?>

						<div class="testimonial-wrapper clearfix">
							
							<div class="testimonial-image">
							<?php				
								if(has_post_thumbnail()) {
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'testimonial-thumb' );
									echo '<img src="' . $src[0] . '" alt="" class="testimonial-guest" />';
								}
								else {
									echo '<img src="' . get_template_directory_uri() .'/images/guest.png" alt="" class="testimonial-guest" />';
								}			
							?>
							</div>

							<div class="testimonial-text"><?php the_content(); ?></div>
							<div class="testimonial-speech"></div>
						</div>

						<p class="testimonial-author"><?php echo $testimonial_guest; ?> - <span><?php echo $testimonial_room ?></span></p>
							
					<?php endwhile; else : ?>

						<p><?php _e('No testimonials have been added yet','qns'); ?></p>
					
					<?php endif; ?>

				<?php // Include Pagination feature
					load_template( get_template_directory() . '/includes/pagination.php' );
				?>	
					
			<!-- END .page-content -->
			</div>
					
		<!-- END .main-content -->
		</div>

		<?php get_sidebar(); ?>

	<!-- END .section -->
	</div>

<?php get_footer(); ?>