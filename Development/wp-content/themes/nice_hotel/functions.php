<?php

/* ------------------------------------------------
	Theme Setup
------------------------------------------------ */

if ( ! isset( $content_width ) ) $content_width = 640;

add_action( 'after_setup_theme', 'qns_setup' );

if ( ! function_exists( 'qns_setup' ) ):

function qns_setup() {

	add_theme_support( 'post-thumbnails' );
	
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
	        set_post_thumbnail_size( "100", "100" );  
	}

	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'testimonial-thumb', 65, 65, true );
		add_image_size( 'recent-posts-widget', 66, 66, true );
		add_image_size( 'slideshow-big', 960, 420, true );
		add_image_size( 'blog-thumb-small', 205, 107, true );
		add_image_size( 'blog-thumb-large', 612, 107, true );
		add_image_size( 'accommodation-thumb', 600, 373, true );
		add_image_size( 'accommodation-full', 730, 526, true );
		add_image_size( 'sponsor-thumb', 9999, 77 );
		add_image_size( 'photo-gallery', 293, 188, true );
	}
	
	add_theme_support( 'automatic-feed-links' );
	
	load_theme_textdomain( 'qns', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) ) require_once( $locale_file );

	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'qns' ),
	) );

}
endif;



/* ------------------------------------------------
	Comments Template
------------------------------------------------ */

if( ! function_exists( 'qns_comments' ) ) {
	function qns_comments($comment, $args, $depth) {
	   $path = get_template_directory_uri();
	   $GLOBALS['comment'] = $comment;
	   ?>
	
		<li <?php comment_class('comment_list'); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-wrapper">
				<div class="author-image">
					<?php echo get_avatar( $comment, 32 ); ?>
				</div>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<div class="msg success clearfix"><p><?php _e( 'Your comment is awaiting moderation.', 'qns' ); ?></p></div>
				<?php endif; ?>
				
				<p class="comment-author"><?php printf( __( '%s', 'qns' ), sprintf( '%s', get_comment_author_link() ) ); ?>
				<span>
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php printf( __( '%1$s at %2$s', 'qns' ), get_comment_date(),  get_comment_time() ); ?>
					</a>
				</span></p>
				
				<?php comment_text(); ?>
				
				<p><span class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					<?php edit_comment_link( __( '(Edit)', 'qns' ), ' ' ); ?>
				</span></p>
				
			</div>			

	<?php
	}
}



/* ------------------------------------------------
   Options Panel
------------------------------------------------ */

require_once ('admin/index.php');



/* ------------------------------------------------
	Register Sidebars
------------------------------------------------ */

function qns_widgets_init() {

	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'qns' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'qns' ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title clearfix"><h5>',
		'after_title' => '</h5></div>',
	) );
	
	// Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer Widget Area One', 'qns' ),
		'id' => 'footer-widget-area-one',
		'description' => __( 'Footer widget area one', 'qns' ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title clearfix"><h5>',
		'after_title' => '</h5></div>',
	) );
	
	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer Widget Area Two', 'qns' ),
		'id' => 'footer-widget-area-two',
		'description' => __( 'Footer widget area two', 'qns' ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title clearfix"><h5>',
		'after_title' => '</h5></div>',
	) );
	
	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer Widget Area Three', 'qns' ),
		'id' => 'footer-widget-area-three',
		'description' => __( 'Footer widget area three', 'qns' ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title clearfix"><h5>',
		'after_title' => '</h5></div>',
	) );

}

add_action( 'widgets_init', 'qns_widgets_init' );



/* ------------------------------------------------
	Register Menu
------------------------------------------------ */

if( !function_exists( 'qns_register_menu' ) ) {
	function qns_register_menu() {

		register_nav_menus(
		    array(
				'primary' => __( 'Primary Navigation','qns' ),
				'secondary' => __( 'Secondary Navigation','qns' ),
				'footer' => __( 'Footer Navigation','qns' )
		    )
		  );
		
	}

	add_action('init', 'qns_register_menu');
}



/* ------------------------------------------------
	Add Description Field to Menu
------------------------------------------------ */

class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0) {
				$description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
}



/* ------------------------------------------------
	Get Post Type
------------------------------------------------ */

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}



/* ------------------------------------------------
   Register Dependant Javascript Files
------------------------------------------------ */

add_action('wp_enqueue_scripts', 'qns_load_js');

if( ! function_exists( 'qns_load_js' ) ) {
	function qns_load_js() {

		if ( is_admin() ) {
			
		}
		
		else {
			
			// Load JS		
			wp_register_script( 'jquery_ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js',  array( 'jquery' ), '1.8', true );
			wp_register_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', '1.8', true );
			wp_register_script( 'jquery_uicore', get_template_directory_uri() . '/js/jquery.ui.core.js', array( 'jquery' ), '3.1.4', true );
			wp_register_script( 'jquery_uiwidget', get_template_directory_uri() . '/js/jquery.ui.widget.js', array( 'jquery' ), '3.1.4', true );
			wp_register_script( 'jquery_uidatepicker', get_template_directory_uri() . '/js/jquery.ui.datepicker.js', array( 'jquery' ), '3.1.4', true );
			wp_register_script( 'prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ), '3.1.4', true );
			wp_register_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.4.8', true );
			wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.1', true );
			wp_register_script( 'dateprice', get_template_directory_uri() . '/js/dateprice.js', array( 'jquery' ), '1.1.9', true );
			wp_register_script( 'selectivizr', get_template_directory_uri() . '/js/selectivizr-min.js', array( 'jquery' ), '1.0.2', true );
			wp_register_script( 'custom', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1', true );

			wp_enqueue_script( array( 'jquery_ui', 'googlemap', 'jquery_uicore', 'jquery_uiwidget', 'jquery_uidatepicker', 'prettyphoto', 'superfish', 'flexslider', 'custom' ) );
			
			global $is_IE;
			
			if( $is_IE ) wp_enqueue_script( 'selectivizr' );
			
			if( is_page_template('template-booking.php') ) wp_enqueue_script( 'dateprice' );
			if( is_single() ) wp_enqueue_script( 'comment-reply' );
			
			// Load CSS
			wp_enqueue_style('superfish', get_template_directory_uri() .'/css/superfish.css');
			wp_enqueue_style('prettyPhoto', get_template_directory_uri() .'/css/prettyPhoto.css');
			wp_enqueue_style('flexslider', get_template_directory_uri() .'/css/flexslider.css');
			wp_enqueue_style('jquery_datepicker', get_template_directory_uri() .'/css/jqueryui/jquery.ui.datepicker.css');
			wp_enqueue_style('responsive', get_template_directory_uri() .'/css/responsive.css');
			
			global $data; //fetch options stored in $data
			
			if ( $data['base_color'] == 'Cream Red' ) :
				wp_enqueue_style('color', get_template_directory_uri() .'/css/colours/cream-red.css');
			elseif ( $data['base_color'] == 'Green Brown' ) :
				wp_enqueue_style('color', get_template_directory_uri() .'/css/colours/green-brown.css');
			elseif ( $data['base_color'] == 'Green' ) :
				wp_enqueue_style('color', get_template_directory_uri() .'/css/colours/green.css');
			elseif ( $data['base_color'] == 'Purple' ) :
				wp_enqueue_style('color', get_template_directory_uri() .'/css/colours/purple.css');
			else : 
				wp_enqueue_style('color', get_template_directory_uri() .'/css/colours/cream-red.css');
			endif;
			
		}
	}
}

if( !function_exists( 'custom_js' ) ) {

    function custom_js() {
		
		global $data; //fetch options stored in $data
		
		echo '<script>';
		
		// Set slideshow autoplay on/off
		if ( $data['slideshow_autoplay'] ) :
			echo 'var slideshow_autoplay = 3000;';
		else :
			echo 'var slideshow_autoplay = false;';
		endif;
			
		// Set Google Map Lat	
		if ( $data['gmap-top-lat'] ) :
			echo 'var mapLat = ' . $data['gmap-top-lat'] . ';';
		else :	
			echo 'var mapLat = 51.507335;';
		endif;
		
		// Set Google Map Lng	
		if ( $data['gmap-top-lng'] ) :
			echo 'var mapLng = ' . $data['gmap-top-lng'] . ';';
		else :	
			echo 'var mapLng = -0.127683;';
		endif;
		
		// Set Google Map Marker Content
		if ( $data['gmap-top-content'] ) : ?>
			var mapContent = "<?php _e( $data['gmap-top-content'],'qns'); ?>";
		<?php else :	
			echo "var mapContent = '<h2>Nice Hotel</h2><p>1 Main Road, London, UK</p>';";
		endif;
		
		$msgSelectCottage = __('Please select a cottage','qns');
		$msgSelectArrDate = __('Please select a "Arrival" date','qns');
		$msgSelectDepDate = __('Please select a "Departure" date','qns');
		$msgArrDepMatch = __('The "Arrival" and "Departure" dates cannot match one another','qns');
		$msgDepBeforeArr = __('The "Departure" date cannot be before the "Arrival" date','qns');
		
		echo "var msgSelectCottage = '" . $msgSelectCottage . "';";
		echo "var msgSelectArrDate = '" . $msgSelectArrDate . "';";
		echo "var msgSelectDepDate = '" . $msgSelectDepDate . "';";
		echo "var msgArrDepMatch = '" . $msgArrDepMatch . "';";
		echo "var msgDepBeforeArr = '" . $msgDepBeforeArr . "';";
		
		echo 'var goText = "' . __('Go to...','qns') . '";';
		
		echo "</script>\n\n";
		
    }

}

add_action('wp_footer', 'custom_js');



/* ------------------------------------------------
   Load Files
------------------------------------------------ */

// Meta Boxes
include 'functions/accommodation_meta.php';
include 'functions/events_meta.php';
include 'functions/gallery_meta.php';
include 'functions/post_meta.php';
include 'functions/slides_meta.php';
include 'functions/testimonial_meta.php';

// Shortcodes
include 'functions/shortcodes/slideshow.php';
include 'functions/shortcodes/accordion.php';
include 'functions/shortcodes/googlemap.php';
include 'functions/shortcodes/toggle.php';
include 'functions/shortcodes/list.php';
include 'functions/shortcodes/button.php';
include 'functions/shortcodes/columns.php';
include 'functions/shortcodes/video.php';
include 'functions/shortcodes/title.php';
include 'functions/shortcodes/message.php';
include 'functions/shortcodes/dropcap.php';
include 'functions/shortcodes/tabs.php';


// Widgets
include 'functions/widgets/widget-booking.php';
include 'functions/widgets/widget-flickr.php';
include 'functions/widgets/widget-tags.php';
include 'functions/widgets/widget-recent-posts.php';



/* ------------------------------------------------
	Custom CSS
------------------------------------------------ */

function custom_css() {
	
	global $data; //fetch options stored in $data
	
	// Set Font Family
	if ( !$data['custom_font'] ) { 
		$custom_font = "'Cardo', serif"; } 
	else { 
		$custom_font =  $data['custom_font']; 
	}
	
	// Output Custom CSS
	$output = '<style type="text/css">
		h1, h2, h3, h4, h5, h6, #ui-datepicker-div .ui-datepicker-title, .dropcap, .ui-tabs .ui-tabs-nav li, 
		#title-wrapper h1, #main-menu li, #main-menu li span, .flex-caption, .accommodation_img_price {
		font-family: ' . $custom_font . ';
	}
	
	' . $data['custom_css'];
	
	if ( $data['body_background'] ) { 
		$output .= 'body {
			background: url(' . get_template_directory_uri() . '/images/bg.png) ' . $data['body_background'] . ' fixed !important;
		}';
	}
	
	if ( $data['main_color'] ) { 
		$output .= '#navigation, #main-menu ul, blockquote, .page-content table, .ui-tabs .ui-tabs-nav li.ui-tabs-selected, .booknow, .booknow-accompage,
			.ui-datepicker .ui-state-highlight, .ui-datepicker .ui-state-default:hover, .ui-datepicker .ui-widget-content .ui-state-default:hover, 
			.ui-datepicker .ui-widget-header .ui-state-default:hover, .accommodation_img_price {
			border-color: ' . $data['main_color'] . ' !important;
		}

		.title-end, .blog-title .comment-count, .blog-title-single .comment-count, .event-prev .event-prev-date, #ui-datepicker-div .ui-datepicker-header,
		.widget .widget-title h5 {
			background: ' . $data['main_color'] . ' !important;
		}

		.button1, .bookbutton {
			background: url(' . get_template_directory_uri() . '/images/gradient1.png) ' . $data['main_color'] . ' bottom left repeat-x !important;
		}

		.button1:hover, .bookbutton:hover {
			background: url(' . get_template_directory_uri() . '/images/gradient1h.png) ' . $data['main_color'] . ' left bottom repeat-x !important;
		}

		.blog-title .comment-count .comment-point,
		.blog-title-single .comment-count .comment-point {
			background: url(' . get_template_directory_uri() . '/images/comment-point.png) ' . $data['main_color'] . ' no-repeat !important;
		}

		#slides .prev, #slides1 .prev, #slides .next, #slides1 .next, #twitter_icon:hover, #facebook_icon:hover, #googleplus_icon:hover, #skype_icon:hover, 
		#flickr_icon:hover, #linkedin_icon:hover, #vimeo_icon:hover, #youtube_icon:hover, #rss_icon:hover  {
			background-color: ' . $data['main_color'] . ' !important;
		}

		.accordion h4.ui-state-active, .toggle .active, .page-content a, .page-full a, .sidebar a:hover, .blog-title-single h2 a,
		.ui-datepicker .ui-state-highlight, .ui-datepicker .ui-state-default:hover, .ui-datepicker .ui-widget-content .ui-state-default:hover, 
		.ui-datepicker .ui-widget-header .ui-state-default:hover, #footer a:hover, #footer-bottom a:hover {
			color: ' . $data['main_color'] . ' !important;
		}

		.widget .widget-title h5:before {
			border-color: ' . $data['main_color'] . ' transparent !important;
		}
	
		.ie8 .flex-caption {
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#80' . str_replace("#","",$data['main_color']) . ',endColorstr=#80' . str_replace("#","",$data['main_color']) . ') !important;
		}';
	
	}

	if ( $data['main_colorrgba'] ) { 
		$output .= '.flex-caption {
			background: ' . $data['main_colorrgba'] . ' !important;
		}';
	}


	if ( $data['main_colorshadow'] ) { 
		$output .= '.corner-left { 
			border-top: 20px solid !important;
			border-color: ' . $data['main_colorshadow'] . ' !important;
			border-left: 20px solid transparent !important; 
		}

		.corner-right { 
			border-top: 20px solid !important; 
			border-color: ' . $data['main_colorshadow'] . ' !important;
			border-right: 20px solid transparent !important;
		}

		.corner-right-small {
			border-top: 8px solid !important; 
			border-color: ' . $data['main_colorshadow'] . ' !important;
			border-right: 8px solid transparent !important;
		}';
	}
	
	if ( $data['nav_color'] ) { 
		$output .= '.top-bar, .gmap-btn-wrapper, #navigation, .booknow-accompage, .booknow, #footer, .accommodation_img_price {
			background: url(' . get_template_directory_uri() . '/images/bgd.png) ' . $data['nav_color'] . ' !important;
		}

		#footer-bottom {
			background: ' . $data['nav_color'] . ' !important;
		}';
	}
	
	if ( $data['navbt_color'] ) { 
		$output .= '#footer-bottom {
			color: ' . $data['navbt_color'] . ' !important;
		}

		.booknow-accompage .price-detail, #main-menu li span, .widget .latest-posts-list li .lpl-content h6 span {
			color: ' . $data['navbt_color'] . ' !important;
		}

		#main-menu li, .main-menu-contact-info li, #footer .widget ul li, #footer .widget .wp-tag-cloud li, #footer .widget .wp-tag-cloud li:last-child {
			border-color: ' . $data['navbt_color'] . ' !important;
		}

		#footer {
			color: ' . $data['navbt_color'] . ' !important;
		}';
	}
	
	$output .= '</style>';
	
  return $output;
}



/* ------------------------------------------------
	Remove width/height dimensions from <img> tags
------------------------------------------------ */

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
add_filter('wp_get_attachment_link', 'remove_thumbnail_dimensions', 10, 1);

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}



/* ------------------------------------------------
	Remove rel attribute from the category list
------------------------------------------------ */

function remove_category_list_rel($output)
{
  $output = str_replace(' rel="category"', '', $output);
  return $output;
}
add_filter('wp_list_categories', 'remove_category_list_rel');
add_filter('the_category', 'remove_category_list_rel');



/* -----------------------------------------------------
	Remove <p> / <br> tags from nested shortcode tags
----------------------------------------------------- */

add_filter('the_content', 'shortcode_fix');
function shortcode_fix($content)
{   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);

	return $content;
}



/* ------------------------------------------------
	Excerpt Length
------------------------------------------------ */

function qns_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'qns_excerpt_length' );



/* ------------------------------------------------
	Excerpt More Link
------------------------------------------------ */

function qns_continue_reading_link() {
	
	// Don't Display Read More Button On Search Results / Archive Pages
	if ( is_post_type( "accommodation" )) {
		$btn_text = _('Details');
	}
	
	else {
		$btn_text = _('Read More');
	}
	
	
	if ( !is_search() && !is_archive() ) {
		return ' <p><a href="'. get_permalink() . '"' . __( ' class="button2">' . $btn_text . ' &raquo;</a></p>', 'qns' );
	}
	
}

function qns_auto_excerpt_more( $more ) {
	return qns_continue_reading_link();
}
add_filter( 'excerpt_more', 'qns_auto_excerpt_more' );



/* ------------------------------------------------
	The Title
------------------------------------------------ */

function qns_filter_wp_title( $title, $separator ) {
	
	if ( is_feed() )
		return $title;

	global $paged, $page;

	if ( is_search() ) {
		$title = sprintf( __( 'Search results for %s', 'qns' ), '"' . get_search_query() . '"' );
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'qns' ), $paged );
		$title .= " $separator " . home_url( 'name', 'display' );
		return $title;
	}

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'qns' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'qns_filter_wp_title', 10, 2 );



/* ------------------------------------------------
	Sidebar Position
------------------------------------------------ */

function sidebar_position( $position ) {
	
	global $data; //fetch options stored in $data
	
	if ( $data['sidebar_position'] ) { 
		$sidebar = $data['sidebar_position']; 
	}

	else { 
		$sidebar = 'right';
	}
	
	if ( $sidebar == 'left' && $position == 'primary-content' ) {
		$output = 'main-content main-content-right last-col';
	}
	
	if ( $sidebar == 'right' && $position == 'primary-content' ) {
		$output = 'main-content';
	}
	
	if ( $sidebar == 'left' && $position == 'secondary-content' ) {
		$output = 'sidebar sidebar-left';
	}
	
	if ( $sidebar == 'right' && $position == 'secondary-content' ) {
		$output = 'sidebar last-col';
	}
	
	if ( $sidebar == 'none' && $position == 'primary-content' ) {
		$output = 'main-content full-width';
	}
	
	if ( $sidebar == 'none' && $position == 'secondary-content' ) {
		$output = 'full-width';
	}
	
	return $output;

}



/* ------------------------------------------------
	Menu Fallback
------------------------------------------------ */

function wp_page_menu_qns( $args = array() ) {
	$defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'wp_page_menu_qns_args', $args );

	$menu = '';

	$list_args = $args;

	// Show Home in the menu
	if ( ! empty($args['show_home']) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = __('Home','qns');
		else
			$text = $args['show_home'];
		$class = '';
		if ( is_front_page() && !is_paged() )
			$class = 'class="current_page_item"';
		$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '" title="' . esc_attr($text) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
		// If the front page is a page, add it to the exclude list
		if (get_option('show_on_front') == 'page') {
			if ( !empty( $list_args['exclude'] ) ) {
				$list_args['exclude'] .= ',';
			} else {
				$list_args['exclude'] = '';
			}
			$list_args['exclude'] .= get_option('page_on_front');
		}
	}

	$list_args['echo'] = false;
	$list_args['title_li'] = '';
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

	if ( $menu )
		$menu = '<ul id="main-menu" class="fl">' . $menu . '</ul>';

	$menu = $menu . "\n";
	$menu = apply_filters( 'wp_page_menu_qns', $menu, $args );
	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;
}



/* ------------------------------------------------
	Password Protected Post Form
------------------------------------------------ */

add_filter( 'the_password_form', 'qns_password_form' );

function qns_password_form() {
	
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$form = '<div class="msg fail clearfix"><p class="nopassword">' . __( 'This post is password protected. To view it please enter your password below', 'qns' ) . '</p></div>
<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-pass.php" method="post"><label for="' . $label . '">' . __( 'Password', 'qns' ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" /><div class="clearboth"></div><input id="submit" type="submit" value="' . esc_attr__( "Submit" ) . '" name="submit"></form>';
	return $form;
	
}



/* ------------------------------------------------
	Google Fonts
------------------------------------------------ */

function google_fonts() {
	
	global $data; //fetch options stored in $data
	
	$output = '';
	
	if ( !$data['custom_font_code'] ) {
		$output .= "<link href='http://fonts.googleapis.com/css?family=Cardo:400,400italic,700' rel='stylesheet' type='text/css'>"; 
	}

	else { 
		$output .= $data['custom_font_code']; 
	}
	
	return $output;
	
}



/* ------------------------------------------------
	Page Header
------------------------------------------------ */

function page_header( $url ) {
	
	global $data; //fetch options stored in $data
	
	$header_url = '';
	
	// If custom page header is set
	if ( $url != '' ) {
		$header_url = $url;
	}
	
	// If default page header is set and custom header is not set
	if ( $data['default_header_url'] && $url == '' ) {
		$header_url = $data['default_header_url'];
	}
	
	// If either of the above is set
	if ( $header_url != '' ) :
		$output = '';	
		$output .= '<!-- BEGIN #page-header -->';
		$output .= '<div id="page-header">';
		$output .= '<img src="' . $header_url . '" alt="" />';
		$output .= '<!-- END #page-header -->';
		$output .= '</div>';
		return $output;
	endif;
	
}



/* ------------------------------------------------
	Email Validation
------------------------------------------------ */

function valid_email($email) {
	
	$result = TRUE;
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
    	$result = FALSE;
	}
  	
	return $result;
	
}



/* ------------------------------------------------
	Add PrettyPhoto for Attached Images
------------------------------------------------ */

add_filter( 'wp_get_attachment_link', 'sant_prettyadd');
function sant_prettyadd ($content) {
     $content = preg_replace("/<a/","<a
rel=\"prettyPhoto[slides]\"",$content,1);
     return $content;
}



/* ------------------------------------------------
	Social Icons
------------------------------------------------ */

function no_icons() {
	
	global $data; //fetch options stored in $data
	
	if( $data['social_twitter'] ) { $twitter = $data['social_twitter']; }
	else { $twitter = ''; }

	if( $data['social_facebook'] ) { $facebook = $data['social_facebook']; }
	else { $facebook = ''; }

	if( $data['social_googleplus'] ) { $googleplus = $data['social_googleplus']; }
	else { $googleplus = ''; }

	if( $data['social_skype'] ) { $skype = $data['social_skype']; }
	else { $skype = ''; }

	if( $data['social_flickr'] ) { $flickr = $data['social_flickr']; }
	else { $flickr = ''; }

	if( $data['social_linkedin'] ) { $linkedin = $data['social_linkedin']; }
	else { $linkedin = ''; }

	if( $data['social_vimeo'] ) { $vimeo = $data['social_vimeo']; }
	else { $vimeo = ''; }

	if( $data['social_youtube'] ) { $youtube = $data['social_youtube']; }
	else { $youtube = ''; }

	if( $data['social_rss'] ) { $rss = $data['social_rss']; }
	else { $rss = ''; }
	
	if ( $twitter == '' && $facebook == '' && $googleplus == '' && $skype == '' && $flickr == '' && $linkedin == '' && $vimeo == '' && $youtube == '' && $rss == '' ) {
		return true;
	}
}

function display_social() {
	
	global $data; //fetch options stored in $data
	
	if( $data['social_twitter'] ) { $twitter = $data['social_twitter']; }
	else { $twitter = ''; }

	if( $data['social_facebook'] ) { $facebook = $data['social_facebook']; }
	else { $facebook = ''; }

	if( $data['social_googleplus'] ) { $googleplus = $data['social_googleplus']; }
	else { $googleplus = ''; }

	if( $data['social_skype'] ) { $skype = $data['social_skype']; }
	else { $skype = ''; }

	if( $data['social_flickr'] ) { $flickr = $data['social_flickr']; }
	else { $flickr = ''; }

	if( $data['social_linkedin'] ) { $linkedin = $data['social_linkedin']; }
	else { $linkedin = ''; }

	if( $data['social_vimeo'] ) { $vimeo = $data['social_vimeo']; }
	else { $vimeo = ''; }

	if( $data['social_youtube'] ) { $youtube = $data['social_youtube']; }
	else { $youtube = ''; }

	if( $data['social_rss'] ) { $rss = $data['social_rss']; }
	else { $rss = ''; }
	
	$output = '';
	
	if ( no_icons() !== true ) {
		$output .= '<ul class="social-icons fl">';
	}	

	if( $twitter !== '' ) {
		$output .= '<li><a href="' . $twitter . '"><span id="twitter_icon"></span></a></li>';
	}

	if( $facebook !== '' ) {
		$output .= '<li><a href="' . $facebook . '"><span id="facebook_icon"></span></a></li>';
	}

	if( $googleplus !== '' ) {
		$output .= '<li><a href="' . $googleplus . '"><span id="googleplus_icon"></span></a></li>';
	}

	if( $skype !== '' ) {
		$output .= '<li><a href="' . $skype . '"><span id="skype_icon"></span></a></li>';
	 }

	if( $flickr !== '' ) {
		$output .= '<li><a href="' . $flickr . '"><span id="flickr_icon"></span></a></li>';
	}

	if( $linkedin !== '' ) {
		$output .= '<li><a href="' . $linkedin . '"><span id="linkedin_icon"></span></a></li>';
	}

	if( $vimeo !== '' ) {
		$output .= '<li><a href="' . $vimeo . '"><span id="vimeo_icon"></span></a></li>';
	}

	if( $youtube !== '' ) {
		$output .= '<li><a href="' . $youtube . '"><span id="youtube_icon"></span></a></li>';
	}

	if( $rss !== '' ) {
		$output .= '<li><a href="' . $rss . '"><span id="rss_icon"></span></a></li>';
	}

	if ( no_icons() !== true ) {
		$output .= '</ul>';
	}
	
	return $output;
	
}
