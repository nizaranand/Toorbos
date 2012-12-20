<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	
	<div class="clearboth"></div>
	
	<?php
		
		if ( is_post_type( "event" )) {
			$page_class = '';
		}
		elseif ( is_post_type( "testimonial" )) {
			$page_class = '';
		}
		else {
			$page_class = 'page-pagination-full';
		}
	
	?>
	
	<!--BEGIN .page-pagination -->
	<div class="page-pagination <?php echo $page_class; ?>">
	
		<p class="clearfix">
			<span class="fl"><?php next_posts_link( __( '&larr; Older posts', 'qns' ) ); ?></span>
			<span class="fr"><?php previous_posts_link( __( 'Newer posts &rarr;', 'qns' ) ); ?></span>
		</p>
	
	<!--END .page-pagination -->
	</div>

<?php endif; ?>