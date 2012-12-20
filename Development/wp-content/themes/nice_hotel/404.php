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
		
			<h2 class="page-title">
				<?php _e('Page Not Found', 'qns'); ?>
			</h2>
			
			<div class="page-content">
				<p><?php echo __('Oops! looks like you clicked on a broken link.','qns') . ' <a href="' . home_url() . '">' . __('Go home?</a>', 'qns') ?></p>
			</div>
		
		<!-- END .main-content -->
		</div>
				
		<?php get_sidebar(); ?>
		
	<!-- END .section -->
	</div>

<?php get_footer(); ?>