<?php if ( is_page_template('template-left-sidebar.php') ) : ?>
	<!-- BEGIN .sidebar -->
	<div class="sidebar sidebar-left">
		<?php dynamic_sidebar( 'primary-widget-area' ); ?>
	</div>
	
<?php elseif ( is_page_template('template-right-sidebar.php') ) : ?>
	<!-- BEGIN .sidebar -->
	<div class="sidebar last-col">
		<?php dynamic_sidebar( 'primary-widget-area' ); ?>
	</div>

<?php else : ?>
	<?php if ( sidebar_position('secondary-content') != 'full-width' ) { ?>
	<div class="<?php echo sidebar_position('secondary-content'); ?>">
		<?php dynamic_sidebar( 'primary-widget-area' ); ?>
	</div>
	<?php } ?>
	
<?php endif; ?>