<?php 

/* 
Template Name: Events 
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
				<div class="page-content event-list-wrapper">
					
					<?php the_content(); ?>
					
					<?php
						
						if( $data['items_per_page'] ) { 
							$event_perpage = $data['items_per_page'];
						}
						else {
							$event_perpage = '10';
						}
					
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
						query_posts( "post_type=event&posts_per_page=$event_perpage&paged=$paged" );

			    		if( have_posts() ) :
						while( have_posts() ) : the_post(); ?>

							<?php
								
								// Get event date
								$e_date = get_post_meta($post->ID, $prefix.'event_date', true);
								if ( $e_date !== '' ) { 									
									$event_date_string = $e_date;
									$event_monthM = mysql2date( 'M', $event_date_string );
									$event_day = mysql2date( 'd', $event_date_string );
									$event_month = apply_filters('get_the_date', $event_monthM, 'M');
								}
								
								// If no date set
								else { 
								
									$event_month = "---";
									$event_day = "00";
								
								}
								
								// Get event time
								$e_time = get_post_meta($post->ID, $prefix.'event_time', true);
								if ( $e_time !== '' ) { $event_time = $e_time; }
								else { $event_time = __('No time set','qns'); }
								
								// Get event location
								$e_location = get_post_meta($post->ID, $prefix.'event_location', true);
								if ( $e_location !== '' ) { $event_location = $e_location; }
								else { $event_location = __('No location set','qns'); }
							
							?>
							
							<!-- BEGIN .event-prev -->	
							<div class="event-prev clearfix">
								<div class="event-prev-date">
									<p class="month"><?php echo $event_month; ?></p>
									<p class="day"><?php echo $event_day; ?></p>
								</div>
								<div class="event-prev-content">
									<h4><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
									<p><strong><?php _e('Time','qns') ?>:</strong> <?php echo $event_time; ?> <br>
									<strong><?php _e('Location','qns') ?>:</strong> <?php echo $event_location; ?></p>
								</div>
							<!-- END .event-prev -->
							</div>

						<?php endwhile; else : ?>

							<p><?php _e('No events have been added yet','qns'); ?></p>
						
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