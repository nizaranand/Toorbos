<?php 
	// Fetch options stored in $data
	global $data; 
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<!-- BEGIN head -->
<head>

	<!-- Meta Tags -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	
	<?php 
		// Dislay Google Analytics Code
		if( $data['google-analytics'] ) { 
			echo $data['google-analytics'];
		}
	?>
	
	<!-- Title -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css"  media="all"  />
	
	<?php // Load Google Fonts
		echo google_fonts();
	?>
	
	<?php // Load Custom CSS 
		echo custom_css(); 
	?>
	
	<!-- RSS Feeds & Pingbacks -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head() ?>

<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>

	<!-- BEGIN .background-wrapper -->
	<div class="background-wrapper">
		
		<!-- BEGIN .content-wrapper -->
		<div class="content-wrapper">
		
			<!-- BEGIN .content-body -->
			<div class="content-body">
				
				<?php if( $data['top-google-map'] ) { ?>
					<!-- BEGIN #header-google-map -->
					<div id="header-google-map" style="display:none;">
						<div id="map_canvas" style="width:100%;height:300px;"></div>
						<!-- END #header-google-map -->
					</div>
				<?php } ?>
				
				<!-- BEGIN .top-bar -->
				<div class="top-bar clearfix">
					
					<?php echo display_social(); ?>
					
					<?php if( $data['top-google-map'] ) { ?>
						<!-- BEGIN .gmap-btn-wrapper -->
						<div class="gmap-btn-wrapper">
							<a href="#" class="gmap-btn"></a>
							<div class="gmap-curve"></div>
							<!-- END .gmap-btn-wrapper -->
						</div>
					<?php } ?>
					
					<!-- BEGIN .top-menu-wrapper -->
					<div class="top-menu-wrapper fr clearfix<?php if( $data['top-google-map'] ) { echo ' map-on'; } ?>">
		
						<?php // Display Top Right Button
							if( $data['top-right-btn'] ) {
						?>
							<a href="<?php echo $data['top-right-btn-link']; ?>" class="button1 fl"><span>
								<?php
									if ( $data['top-right-btn-text'] ) :
										_e($data['top-right-btn-text'],'qns');
									else :
										_e('Book Now','qns');
									endif;
								?>
							</span></a>

						<?php } ?>

						<?php if ( has_nav_menu( 'secondary' ) ) { ?>

							<!-- Secondary Menu -->
							<?php wp_nav_menu( array(
								'theme_location' => 'secondary',
								'container' =>false,
								'items_wrap' => '<ul class="top-menu fr">%3$s</ul>',
								'echo' => true,
								'before' => '',
								'after' => '<span> /</span>',
								'link_before' => '',
								'link_after' => '',
								'depth' => 0 )
						 	); ?>

						<?php } ?>
						
						
					<!-- END .top-menu-wrapper -->
					</div>
					
				<!-- END .top-bar -->
				</div>
				
				<?php if( $data['text_logo'] ) : ?>
					<div id="title-wrapper">
						<h1>
							<div class="title-dec-left"></div>
							<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?>
							<span id="tagline"><?php bloginfo( 'description' ) ?></span></a>
							<div class="title-dec-right"></div>
						</h1>
					</div>

				<?php elseif( $data['image_logo'] ) : ?>
					<div id="title-wrapper">
						<h1>
							<a href="<?php echo home_url(); ?>"><img src="<?php echo $data['image_logo']; ?>" alt="" /></a>
							<span id="tagline"><?php bloginfo( 'description' ) ?></span>
						</h1>
					</div>

				<?php else : ?>	
					<div id="title-wrapper">
						<h1>
							<div class="title-dec-left"></div>
							<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?>
							<span id="tagline"><?php bloginfo( 'description' ) ?></span></a>
							<div class="title-dec-right"></div>
						</h1>
					</div>
				<?php endif ?>
				
				<!-- BEGIN #navigation -->
				<div id="navigation" class="clearfix<?php if ( $data['nav_contact'] ) { echo ' nav-contact'; }?>">
					
					<!-- BEGIN .nav-wrapper -->
					<div class="nav-wrapper">
					
					<?php if ( has_nav_menu( 'primary' ) ) { ?>
					
						<!-- Main Menu -->
						<?php wp_nav_menu( array(
							'theme_location' => 'primary',
							'container' =>false,
							'items_wrap' => '<ul id="main-menu" class="fl clearfix">%3$s</ul>',
							'fallback_cb' => 'wp_page_menu_qns',
							'echo' => true,
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'depth' => 0,
							'walker' => new description_walker() )
				 		); ?>
				
					<?php } else { ?>
						
						<!-- Main Menu -->
						<?php wp_nav_menu( array(
							'theme_location' => 'primary',
							'container' =>false,
							'items_wrap' => '<ul id="main-menu" class="fl clearfix">%3$s</ul>',
							'fallback_cb' => 'wp_page_menu_qns',
							'echo' => true,
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'depth' => 0 )
					 	); ?>
						
					<?php } ?>
					
					<!-- Mobile Menu -->
					<?php wp_nav_menu( array(
						'theme_location' => 'primary',
						'container' =>false,
						'items_wrap' => '<ul id="mobile-menu" class="fl clearfix">%3$s</ul>',
						'fallback_cb' => 'wp_page_menu_qns',
						'echo' => true,
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'depth' => 0 )
				 	); ?>
						
					<?php		
						
						if ( $data['nav_contact'] ) {
							if ( $data['phone_number'] or $data['email_address'] ) {
								echo '<ul class="main-menu-contact-info fr">';	
									if ( $data['phone_number'] ) {
										echo '<li class="info-phone">' . $data['phone_number'] . '</li>';
									}	
									if ( $data['email_address'] ) {
										echo '<li class="info-email">' . $data['email_address'] . '</li>';
									}	
								echo '</ul>';
							}
						}
					?>
			
					<div class="corner-left"></div>
					<div class="corner-right"></div>
					
					<!-- END .nav-wrapper -->
					</div>
					
				<!-- END #navigation -->
				</div>