<?php get_header(); ?>

	<?php
	
	// Fetch options stored in $data
	global $data;
	
	// Get booking page ID
	$booking_page = $data['booking_page_url'];
	
	?>

	<?php //Display Page Header
		global $wp_query;
		$postid = $wp_query->post->ID;
		echo page_header( get_post_meta($postid, 'qns_page_header_image', true) );
		wp_reset_query();
	?>
	
	<!-- BEGIN .section -->
	<div class="section page-full clearfix">

			<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php
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
					$accommodation_price_info = get_post_meta($post->ID, 'qns_accommodation_price_info', true);
					$accommodation_details = get_post_meta($post->ID, 'qns_accommodation_details', true);
				?>

				<h2 class="page-title"><?php the_title(); ?></h2>

				<!-- BEGIN .page-content -->
				<div class="page-content page-content-full accommodation-single-page">
					
					<!-- BEGIN .even-cols -->
					<div class="even-cols clearfix">
						
						<!-- BEGIN .one-half -->
						<div class="one-half">
							
							<!-- BEGIN .slider -->
							<div class="slider" style="margin: 0 0 30px 0;">

								<!-- BEGIN .slides -->
								<ul class="slides">

									<?php // Get Attachments
										$attachments = get_children(array(
											'post_parent'=> $post->ID, 
											'post_status'=>'inherit', 
											'post_type'=> 'attachment', 
											'post_mime_type'=>'image'
										));

									// Display Attachments
									foreach ( $attachments as $id => $attachment ) {		
										$link = wp_get_attachment_link($id, 'accommodation-full', false); ?>
										
										<li>
											<?php echo $link; ?>
									
											<?php if ( wptexturize($attachment->post_excerpt) != '' ) {
												echo '<div class="flex-caption">' . wptexturize($attachment->post_excerpt) . '</div>';
											} ?>
										
										</li>

									<?php } ?>

								<!-- END .slides -->
								</ul>

							<!-- END .slider -->
							</div>
						
						<!-- END .one-half -->
						</div>
						
						<!-- BEGIN .one-half -->
						<div class="one-half last-col">
							<h3 class="title1"><?php _e('Cottage Description','qns'); ?><span class="title-end"></span></h3>
							<?php the_content(); ?>
							
							<!-- BEGIN .booknow-accompage -->
							<div class="booknow-accompage">
								
								<div class="book-price">
									
									<h2 class="price"><?php echo $currency_unit.$accommodation_price; ?><span class="price-detail"><?php echo $accommodation_price_info; ?></span></h2>
									
									<div class="price-tl"></div>
									<div class="price-tr"></div>
									<div class="price-bl"></div>
									<div class="price-br"></div>
									
								</div>
								
								<form class="booking-form booking-form-accompage booking-validation" name="bookroom" action="<?php echo $booking_page; ?>" method="post">

									<input type="text" name="book_cottage_type" value="<?php the_title(); ?>" class="text-input" disabled="disabled">

									<div class="clearfix">
										<input type="text" id="datefrom" name="book_date_from" value="<?php _e('From','qns'); ?>" class="input-half datepicker">
										<input type="text" id="dateto" name="book_date_to" value="<?php _e('To','qns'); ?>" class="input-half input-half-last datepicker">
									</div>
									
									<input type="hidden" name="book_cottage_type" value="<?php the_title(); ?>" />
									<input type="hidden" name="book_cottage_price" value="<?php echo $accommodation_price; ?>" />
									<input type="hidden" name="book_confirm" value="1" />
									
									<input class="bookbutton" type="submit" value="<?php _e('Book Now','qns'); ?>" />

								</form>
							
							<!-- END .booknow-accompage -->
							</div>
						
						<!-- END .one-half -->
						</div>
					
					<!-- END .even-cols -->
					</div>
					
					<?php if( $accommodation_details ) : ?>
						<h3 class="title1"><?php _e('Cottage Facilities','qns'); ?><span class="title-end"></span></h3>
						<?php echo do_shortcode($accommodation_details); ?>
				
					<?php else : ?>
						<div class="bottom-margin"></div>
					
					<?php endif; ?>
					
					<?php endwhile; endif; ?>

				<!-- END .page-content -->
				</div>
		
	<!-- END .section -->
	</div>

<?php get_footer(); ?>