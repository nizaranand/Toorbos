<?php 

/* 
Template Name: Full Width 
*/ 

?>

<?php get_header(); ?>

	<?php //Display Page Header
		global $wp_query;
		$postid = $wp_query->post->ID;
		echo page_header( get_post_meta($postid, 'qns_page_header_image', true) );
		wp_reset_query();
	?>
			
	<!-- BEGIN .section -->
	<div class="section page-full clearfix">

		<h2 class="page-title page-title-full"><?php the_title(); ?></h2>

		<!-- BEGIN .section -->
		<div class="section page-content full-width-page blog-list-wrapper clearfix">

				<?php load_template( get_template_directory() . '/includes/loop.php' ); ?>
			
		<!-- END .section -->
		</div>

	<!-- END .section -->
	</div>

<?php get_footer(); ?>