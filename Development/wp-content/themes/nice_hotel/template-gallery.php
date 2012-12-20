<?php 

/* 
Template Name: Photo Gallery 
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
	<div class="section gallery-page page-full clearfix">

		<h2 class="page-title page-title-full"><?php the_title(); ?></h2>

		<!-- BEGIN .section -->
		<div class="section even-cols section-bm clearfix">
			
			<?php if( get_the_content() ) {
				echo '<div class="page-content page-content-full-border">';
				the_content(); 
				echo '</div>';
			} ?>
			
			<?php
				
				if( $data['items_per_page'] ) { 
					$gallery_perpage = $data['items_per_page'];
				}
				else {
					$gallery_perpage = '10';
				}
					
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
				query_posts( "post_type=gallery&posts_per_page=$gallery_perpage&paged=$paged" );

				if( have_posts() ) :
				$c = 0;while (have_posts()) : the_post(); $c++; ?>

				<?php
					$col_number = 3;
					$col_type = 'one-third-full';
						
					if( $c == $col_number) {
						$last_col = ' last-col-full';
						$c = 0;
					}
					else $last_col='';
				?>

					<!-- BEGIN .one-third-full -->
					<div class="<?php echo $col_type . $last_col; ?>">
								
						<!-- BEGIN .gallery-item -->
						<div class="gallery-item">
								
							<!-- BEGIN .gallery-thumbnail -->
							<div class="gallery-thumbnail">
									
								<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">	
									<span class="zoom-wrapper">
										<span class="zoom"></span>
									</span>
											
									<?php // if has an image
										if( has_post_thumbnail() ) :	
										// Get the Thumbnail URL
										the_post_thumbnail( 'photo-gallery' );
									?>
									
									<?php // if not display a default image
										else : ?>
										<img src="<?php echo get_template_directory_uri(); ?>/images/image3.png" alt=""/>
									<?php endif; ?>
								
								</a>
								
							<!-- END .gallery-thumbnail -->
							</div>
								
							<h3 class="title1"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class="title-end"></span></h3>
								
						<!-- END .gallery-item -->
						</div>
						
					<!-- END .one-third-full -->
					</div>

				<?php endwhile; else : ?>

					<div class="page-content page-content-full page-padding"><p><?php _e('No photos have been added yet','qns'); ?></p></div>
				
				<?php endif; ?>

			<?php // Include Pagination feature
				load_template( get_template_directory() . '/includes/pagination.php' );
			?>
			
		<!-- END .section -->
		</div>

	<!-- END .section -->
	</div>

<?php get_footer(); ?>