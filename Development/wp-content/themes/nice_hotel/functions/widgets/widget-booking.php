<?php

// Widget Class
class qns_booking_widget extends WP_Widget {


/* ------------------------------------------------
	Widget Setup
------------------------------------------------ */

	function qns_booking_widget() {
		$widget_ops = array( 'classname' => 'booking_widget', 'description' => __('Display Booking Form', 'qns') );
		$control_ops = array( 'width' => 300, 'height' => 300, 'id_base' => 'booking_widget' );
		$this->WP_Widget( 'booking_widget', __('Custom Booking Widget', 'qns'), $widget_ops, $control_ops );
	}


/* ------------------------------------------------
	Display Widget
------------------------------------------------ */
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		 } ?>

		<!-- BEGIN .booknow-sidebar -->
		<div class="booknow-sidebar">

			<!-- BEGIN .booknow -->
			<div class="booknow">
				
				<?php

					// Fetch options stored in $data
					global $data; 

					// Get booking page ID
					$booking_page = $data['booking_page_url'];
				?>
				
				<form class="booking-form booking-validation-widget" name="bookroom" action="<?php echo $booking_page; ?>" method="post">

					<div class="select-wrapper">
						<select id="room_widget" name="book_room_type_and_price">
							<option value="none"><?php _e('Select a Room...','qns'); ?></option>
		
							<?php // Begin Accommodation Query
							query_posts( "post_type=accommodation&posts_per_page=9999" );
							
					    	if( have_posts() ) :
								while( have_posts() ) : the_post(); ?>

									<?php 
										global $wp_query;
										$postid = $wp_query->post->ID;
										
										if (get_post_meta($postid, 'qns_accommodation_price', true) == '') {
											$accommodation_price = '0';
										} 
										else {
											$accommodation_price = get_post_meta($postid, 'qns_accommodation_price', true);
										}
									?>
									
									<option value="<?php echo the_title() . ',' . $accommodation_price; ?>"><?php echo the_title(); ?></option>
								<?php endwhile; endif; ?>
							
						</select>
					</div>

					<div class="clearfix">
						<input type="text" id="datefrom_widget" name="book_date_from" value="<?php _e('From','qns'); ?>" class="input-half datepicker">
						<input type="text" id="dateto_widget" name="book_date_to" value="<?php _e('To','qns'); ?>" class="input-half input-half-last datepicker">
					</div>
					
					<input type="hidden" name="book_confirm" value="1" />
					<input class="bookbutton" type="submit" value="<?php _e('Book Now','qns'); ?>" />

				</form>

				<div class="corner-left"></div>

			<!-- END .booknow -->
			</div>

		<!-- END . booknow-sidebar -->
		</div>
		
		<?php
		
		echo $after_widget;
	}	
	
	
/* ------------------------------------------------
	Update Widget
------------------------------------------------ */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}
	
	
/* ------------------------------------------------
	Widget Input Form
------------------------------------------------ */
	 
	function form( $instance ) {
		$defaults = array(
		'title' => 'Reservations'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
				
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'qns'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
	<?php
	}	
	
}

// Add widget function to widgets_init
add_action( 'widgets_init', 'qns_booking_widget' );

// Register Widget
function qns_booking_widget() {
	register_widget( 'qns_booking_widget' );
}