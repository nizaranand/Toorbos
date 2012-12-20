<?php /* Template Name: Photo Gallery */ ?>

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
		
			<?php // Get Attachments
			$attachments = get_children(array(
				'post_parent'=> $post->ID, 
				'post_status'=>'inherit', 
				'post_type'=> 'attachment', 
				'post_mime_type'=>'image',
				'order' => 'DSC'
			));
			
			// Set Columns
			$columns = 3;
			if ( $columns == 3 ) { $class = 'one-third-full'; }
			if ( $columns == 4 ) { $class = 'one-forth-full'; }
			$i = 0;
			
			// Display Attachments
			foreach ( $attachments as $id => $attachment ) {		
				$link = wp_get_attachment_link($id, 'photo-gallery', true); ?>
				
				<?php 
					if( $i == $columns ){ $i = 1; } else { $i++; } 
				?>

				<?php
					if ( $i == $columns ) { $last_col = ' last-col-full'; }
					else { $last_col = ''; }
				?>

				<!-- BEGIN .one-third-full -->
				<div class="<?php echo $class . $last_col; ?>">
						
					<!-- BEGIN .gallery-item -->
					<div class="gallery-item">
						
						<!-- BEGIN .gallery-thumbnail -->
						<div class="gallery-thumbnail">
							
							<?php
								if ( $data['lightbox_album'] ) {
									$lightbox_album = 'prettyPhoto[gallery]';
								}
								else {
									$lightbox_album = 'prettyPhoto';
								}
							?>
							
							<?php
								$large_image_url = wp_get_attachment_image_src( $id, 'large');
								
								if ( wptexturize($attachment->post_excerpt) != '' ) {
									$image_title = wptexturize($attachment->post_excerpt);
								}
								else {
									$image_title = the_title_attribute('echo=0');
								}
									 
								echo '<a href="' . $large_image_url[0] . '" title="' . $image_title . '" rel="' . $lightbox_album . '">';
							?>
		
							<span class="zoom-wrapper">
								<span class="zoom"></span>
							</span>
				
							<?php
								echo $link;	
							?>

							</a>
						
						<!-- END .gallery-thumbnail -->
						</div>
						
						<?php if ( wptexturize($attachment->post_excerpt) != '' ) { ?>
						
						<h3 class="title1">
						<?php 
							echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" rel="' . $lightbox_album . '">';	
							echo wptexturize($attachment->post_excerpt);
						} ?>
						
						</a><span class="title-end"></span></h3>
						
					<!-- END .gallery-item -->
					</div>
				
				<!-- END .one-third-full -->
				</div>

			<?php } ?>
	
			<!-- END .section -->
			</div>

		<!-- END .section -->
		</div>

<?php get_footer(); ?>