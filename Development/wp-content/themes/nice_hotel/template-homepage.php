<?php 

/* 
Template Name: Homepage 
*/ 

?>

<?php 
	// Fetch options stored in $data
	global $data; 
?>

<?php get_header(); ?>

	<?php // Display Slideshow 
		if ( $data['slideshow_display'] ) : 
	?>

		<!-- BEGIN .slider -->
		<div class="slider <?php if( $data['slide-booking-form'] ) { echo 'slider-booking'; } ?>">
			
			<!-- BEGIN .slides -->
			<ul class="slides">
	
				<?php
					query_posts( "post_type=slideshow&posts_per_page=9999" );

		    		if( have_posts() ) :
					while( have_posts() ) : the_post(); ?>

						<?php	
							// Get slideshow date
							$slideshow_image = get_post_meta($post->ID, $prefix.'slideshow_image', true);
							$slideshow_link = get_post_meta($post->ID, $prefix.'slideshow_link', true);
							$slideshow_caption = get_post_meta($post->ID, $prefix.'slideshow_caption', true);			
						?>
						
						<li>						
							
							<?php
							// If link is set
							if ( $slideshow_link != '' ) {
								echo '<a href="' . $slideshow_link . '">';
							}
							?>
							
							<?php 
							// If featured image is set use this 
							if( has_post_thumbnail() ) {
								$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slideshow-big' );
								echo '<img src="' . $src[0] . '" alt="" />';
							}
							
							// Else if image url is set use this 
							elseif ( $slideshow_image != '' ) { ?>
								<img src="<?php echo $slideshow_image; ?>" alt="" />
							<?php }
							
							// Display caption if it is set
							if ( $slideshow_caption != '' ) { ?>
								<div class="flex-caption"><?php echo $slideshow_caption; ?></div>
							<?php } ?>
							
							<?php
							// If link is set
							if ( $slideshow_link != '' ) {
								echo '</a>';
							}
							?>
							
						</li>

					<?php endwhile; endif; ?>
	
			<!-- END .slides -->
			</ul>
			
			<?php if( $data['slide-booking-form'] ) : ?>
				
			<!-- BEGIN .booknow -->
			<div class="booknow jshide">
				
				<!-- BEGIN .booknow-wrapper -->
				<div class="booknow-wrapper">
				
				<?php			
					// Get booking page ID
					$booking_page = $data['booking_page_url'];
				?>
				
				<form class="booking-form booking-validation" name="bookroom" action="<?php echo $booking_page; ?>" method="post">
					
					<div class="select-wrapper">
						<select id="room" name="book_room_type_and_price">
							<option value="none"><?php _e('Select a Cottage...','qns'); ?></option>

							<?php // Begin Accommodation Query
							query_posts( "post_type=accommodation&posts_per_page=9999" );
							
					    	if( have_posts() ) :
								while( have_posts() ) : the_post(); ?>
								
									<?php 
										if (get_post_meta($post->ID, 'qns_accommodation_price', true) == '') {
											$accommodation_price = '0';
										} 
										else {
											$accommodation_price = get_post_meta($post->ID, 'qns_accommodation_price', true);
										}
									?>
									
									<option value="<?php echo the_title() . ',' . $accommodation_price; ?>"><?php echo the_title(); ?></option>
								<?php endwhile; endif; ?>
							
						</select>
					</div>
					
					<div class="clearfix">
						<input type="text" id="datefrom" name="book_date_from" value="<?php _e('From','qns'); ?>" class="input-half datepicker">
						<input type="text" id="dateto" name="book_date_to" value="<?php _e('To','qns'); ?>" class="input-half input-half-last datepicker">
					</div>
					
					<input type="hidden" name="book_confirm" value="1" />
					<input class="bookbutton" type="submit" value="<?php _e('Book Now','qns'); ?>" />
				
				</form>
				
				<div class="corner-left"></div>
				
				<!-- END .booknow-wrapper -->
				</div>
				
			<!-- END .booknow -->
			</div>
					
			<?php endif; ?>
	
		<!-- END .slider -->
		</div>
		
	<?php endif; ?> 
	
	<?php // Announcement Message
		if ($data['homepage_announcement'] ) : ?>
		<h2 class="intro-msg"><?php _e($data['homepage_announcement'],'qns'); ?></h2>
		<hr>
	<?php endif; ?>

	<!-- BEGIN .section -->
	<div class="section home-blocks clearfix">

		<div class="one-third-full">
			<?php if ($data['homepage_block_title_1'] ) : ?>
				<h3 class="title1"><?php _e($data['homepage_block_title_1'],'qns'); ?><span class="title-end"></span></h3>
			<?php endif;
			_e(do_shortcode($data['homepage_block_content_1']),'qns');
			if ($data['homepage_block_button_1'] ) : ?>
				<p><a href="<?php _e($data['homepage_block_link_1'],'qns'); ?>" class="button2"><?php _e($data['homepage_block_button_1'],'qns'); ?></a></p>
			<?php endif; ?>
		</div>

		<div class="one-third-full featured-wrapper">
			<?php if ($data['homepage_block_title_2'] ) : ?>
				<h3 class="title1"><?php _e($data['homepage_block_title_2'],'qns'); ?><span class="title-end"></span></h3>
			<?php endif;
			_e(do_shortcode($data['homepage_block_content_2']),'qns');
			if ($data['homepage_block_button_2'] ) : ?>
				<p><a href="<?php _e($data['homepage_block_link_2'],'qns'); ?>" class="button2"><?php _e($data['homepage_block_button_2'],'qns'); ?></a></p>
			<?php endif; ?>
			<div class="featured-bottom"></div>	
		</div>
		
		<div class="one-third-full">	
			<?php if ($data['homepage_block_title_3'] ) : ?>
				<h3 class="title1"><?php _e($data['homepage_block_title_3'],'qns'); ?><span class="title-end"></span></h3>
			<?php endif;
			_e(do_shortcode($data['homepage_block_content_3']),'qns');
			if ($data['homepage_block_button_3'] ) : ?>
				<p><a href="<?php _e($data['homepage_block_link_3'],'qns'); ?>" class="button2"><?php _e($data['homepage_block_button_3'],'qns'); ?></a></p>
			<?php endif; ?>		
		</div>

	<!-- END .section -->
	</div>	
	
	<?php if ($data['homepage_testimonial_ids'] != '') : ?>
	
	<hr>
	
	<!-- BEGIN .section -->
	<div class="section testimonials-home clearfix">
		
		<?php
			
			$count = 0;
			$testimonial_posts = $data['homepage_testimonial_ids'];
			$post_in = explode(',', $testimonial_posts);
			
			$args = array(
				'post_type'		=> 'testimonial',
				'post__in'		=> $post_in,
				'numberposts'   => 9999
			);
	
			query_posts($args);

    		if( have_posts() ) :
			while( have_posts() ) : the_post(); ?>

				<?php
					// Get testimonial date
					$testimonial_guest = get_post_meta($post->ID, $prefix.'testimonial_guest', true);
					$testimonial_room = get_post_meta($post->ID, $prefix.'testimonial_room', true);
					
					$count++;
					
					// Add different css class to last item
					if ($count % 2 == 0) {
						$css_class = 'one-half-full testimonial-item-home-last last-col-full';
					}
					else {
						$css_class = 'one-half-full testimonial-item-home';
					}
					
				?>

				<!-- BEGIN .one-half-full -->
				<div class="<?php echo $css_class; ?>">

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
				
				<!-- END .one-half-full -->			
				</div>
				
			<?php endwhile; endif; ?>
		
	<!-- END .section -->
	</div>
	
	<?php endif; ?>
	
<?php get_footer(); ?>