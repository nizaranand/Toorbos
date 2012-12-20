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
				<?php the_title(); ?>
			</h2>
			
			<div class="page-content blog-list-wrapper">
				<?php load_template( get_template_directory() . '/includes/loop.php' ); ?>
			</div>
		
		<!-- END .main-content -->
		</div>
				
		<?php get_sidebar(); ?>
		
	<!-- END .section -->
	</div>

<?php get_footer(); ?>