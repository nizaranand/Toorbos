<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp = array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		// Colour choices
		$colour_array = array("Cream Red","Green Brown","Green","Purple");

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

// General Settings
$of_options[] = array( "name" => "General Settings",
                    "type" => "heading");
					
$url =  ADMIN_DIR . 'assets/images/';
$of_options[] = array( "name" => "Main Layout",
					"desc" => "Select main content and sidebar alignment",
					"id" => "sidebar_position",
					"std" => "right",
					"type" => "images",
					"options" => array(
						'none' => $url . '1col.png',
						'right' => $url . '2cr.png',
						'left' => $url . '2cl.png')
					);
					
$of_options[] = array( "name" => "Text Logo",
						"desc" => "Tick this box if you don't have an image based logo",
						"id" => "text_logo",
						"std" => "0",
						"type" => "checkbox");

$of_options[] = array( "name" => "Image Logo",
						"desc" => "Upload your logo here",
						"id" => "image_logo",
						"type" => "upload");

$of_options[] = array( "name" => "Image Logo Height",
						"desc" => "Enter the logo height",
						"id" => "image_logo_height",
						"std" => "",
						"type" => "text");

$of_options[] = array( "name" => "Display Button In Top Right Bar",
						"desc" => "Tick to display",
						"id" => "top-right-btn",
						"std" => "1",
						"type" => "checkbox");

$of_options[] = array( "name" => "Top Right Button Text",
						"desc" => "Enter custom text for the top right button",
						"id" => "top-right-btn-text",
						"std" => "Book Now",
						"type" => "text");
						
$of_options[] = array( "name" => "Top Right Button Link",
						"desc" => "Enter link URL for the top right button (with http://)",
						"id" => "top-right-btn-link",
						"std" => "",
						"type" => "text");

$of_options[] = array( "name" => "Footer Message",
						"desc" => "Copyright message to be displayed in footer",
						"id" => "footer_msg",
						"std" => "&copy; Copyright 2012",
						"type" => "text");
						
$of_options[] = array( "name" => "Google Analytics Code",
					"desc" => "",
					"id" => "google-analytics",
					"std" => "",
					"type" => "textarea");
					
$of_options[] = array( "name" => "Number of Items Per Page",
					"desc" => "For gallery, testimonial and event listing pages",
					"id" => "items_per_page",
					"std" => "10",
					"type" => "text");

// Styling Options
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");

$of_options[] = array( "name" => "Base Colour",
					"desc" => "Pick a Colour",
					"id" => "base_color",
					"std" => "green",
					"type" => "select",
					"options" => $colour_array);

$of_options[] = array( "name" => "Custom CSS",
					"desc" => "Add any custom CSS you wish here",
					"id" => "custom_css",
					"std" => '',
					"type" => "textarea");
										
$of_options[] = array( "name" => "Google Font",
					"desc" => "Add Google Font Code Here",
					"id" => "custom_font_code",
					"std" => "<link href='http://fonts.googleapis.com/css?family=Cardo:400,400italic,700' rel='stylesheet' type='text/css'>",
					"type" => "textarea");

$of_options[] = array( "name" => "Google Font Name",
					"desc" => "Enter the Google Font name / family",
					"id" => "custom_font",
					"std" => "'Cardo', serif",
					"type" => "text");

$of_options[] = array( "name" => "Default Header Image URL",
					"desc" => "Displayed on all inner pages, don't forget the http://",
					"id" => "default_header_url",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" =>  "Body Background Colour",
					"desc" => "Pick a colour",
					"id" => "body_background",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" =>  "Main Highlight Colour",
					"desc" => "Pick a colour",
					"id" => "main_color",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" =>  "Main Highlight Colour Shadow",
					"desc" => "Pick a slightly dark version of the main highlight colour",
					"id" => "main_colorshadow",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" =>  "Main Highlight Colour in RGBA format",
					"desc" => "Use http://hex2rgba.devoth.com/ e.g. rgba(106, 166, 138, 0.7)",
					"id" => "main_colorrgba",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" =>  "Navigation/Footer Background Colour",
					"desc" => "Pick a colour",
					"id" => "nav_color",
					"std" => "",
					"type" => "color");
					
$of_options[] = array( "name" =>  "Navigation/Footer Text/Border Colour",
					"desc" => "Pick a colour",
					"id" => "navbt_color",
					"std" => "",
					"type" => "color");

// Home Settings
$of_options[] = array( "name" => "Home Settings",
					"type" => "heading");
					
$of_options[] = array( "name" => "Display Slideshow",
					"desc" => "Tick to display slideshow on homepage",
					"id" => "slideshow_display",
					"std" => "0",
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Autoplay Slideshow",
					"desc" => "Tick to autoplay",
					"id" => "slideshow_autoplay",
					"std" => "0",
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Display Booking Form on Slideshow",
					"desc" => "Tick to display",
					"id" => "slide-booking-form",
					"std" => "1",
					"type" => "checkbox");

$of_options[] = array( "name" => "Block Title 1",
					"desc" => "",
					"id" => "homepage_block_title_1",
					"std" => "Block Title 1",
					"type" => "text");					

$of_options[] = array( "name" => "Block Content 1",
					"desc" => "Don't forget to use &lt;p&gt; tags",
					"id" => "homepage_block_content_1",
					"std" => '<p>Block Content 1</p>',
					"type" => "textarea");

$of_options[] = array( "name" => "Block Button Title 1",
					"desc" => "Leave this blank if you don't want a button",
					"id" => "homepage_block_button_1",
					"std" => "Block Button 1",
					"type" => "text");

$of_options[] = array( "name" => "Block Button Link 1",
					"desc" => "",
					"id" => "homepage_block_link_1",
					"std" => "#",
					"type" => "text");

$of_options[] = array( "name" => "Block Title 2",
					"desc" => "",
					"id" => "homepage_block_title_2",
					"std" => "Block Title 2",
					"type" => "text");					

$of_options[] = array( "name" => "Block Content 2",
					"desc" => "Don't forget to use &lt;p&gt; tags",
					"id" => "homepage_block_content_2",
					"std" => '<p>Block Content 2</p>',
					"type" => "textarea");

$of_options[] = array( "name" => "Block Button Title 2",
					"desc" => "Leave this blank if you don't want a button",
					"id" => "homepage_block_button_2",
					"std" => "Block Button 2",
					"type" => "text");

$of_options[] = array( "name" => "Block Button Link 2",
					"desc" => "",
					"id" => "homepage_block_link_2",
					"std" => "#",
					"type" => "text");

$of_options[] = array( "name" => "Block Title 3",
					"desc" => "",
					"id" => "homepage_block_title_3",
					"std" => "Block Title 3",
					"type" => "text");					

$of_options[] = array( "name" => "Block Content 3",
					"desc" => "Don't forget to use &lt;p&gt; tags",
					"id" => "homepage_block_content_3",
					"std" => '<p>Block Content 3</p>',
					"type" => "textarea");

$of_options[] = array( "name" => "Block Button Title 3",
					"desc" => "Leave this blank if you don't want a button",
					"id" => "homepage_block_button_3",
					"std" => "Block Button 3",
					"type" => "text");

$of_options[] = array( "name" => "Block Button Link 3",
					"desc" => "",
					"id" => "homepage_block_link_3",
					"std" => "#",
					"type" => "text");

$of_options[] = array( "name" => "Announcement Message",
					"desc" => "Leave this blank to display no announcement",
					"id" => "homepage_announcement",
					"std" => "This is an example announcement, go and change it in the theme options!",
					"type" => "textarea");
					
$of_options[] = array( "name" => "Testimonial IDs to Display on Homepage",
					"desc" => "Post IDs of testimonials to display separated by a comma. e.g. 1,10,8",
					"id" => "homepage_testimonial_ids",
					"std" => "",
					"type" => "text");
					
// Social Options	
$of_options[] = array( "name" => "Social Settings",
					"type" => "heading");

$of_options[] = array( "name" => "Twitter",
					"desc" => "URL with http://",
					"id" => "social_twitter",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Facebook",
					"desc" => "URL with http://",
					"id" => "social_facebook",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Googleplus",
					"desc" => "URL with http://",
					"id" => "social_googleplus",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Skype",
					"desc" => "URL with http://",
					"id" => "social_skype",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Flickr",
					"desc" => "URL with http://",
					"id" => "social_flickr",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Linkedin",
					"desc" => "URL with http://",
					"id" => "social_linkedin",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Vimeo",
					"desc" => "URL with http://",
					"id" => "social_vimeo",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Youtube",
					"desc" => "URL with http://",
					"id" => "social_youtube",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "RSS Feed",
					"desc" => "URL with http://",
					"id" => "social_rss",
					"std" => "",
					"type" => "text");

// Contact Options
$of_options[] = array( "name" => "Contact Settings",
					"type" => "heading");

$of_options[] = array( "name" => "Contact Form Email",
					"desc" => "Enter the email address you would like the contact form to send emails to",
					"id" => "contact_email",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Street Address",
					"desc" => "To be display in contact details list",
					"id" => "street_address",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Phone Number",
					"desc" => "To be display in contact details list",
					"id" => "phone_number",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Email Address",
					"desc" => "To be display in contact details list",
					"id" => "email_address",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => 'Display phone number and email in navigation bar',
					"desc" => 'Tick to display',
					"id" => "nav_contact",
					"std" => "1",
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Display Google Map In Top Bar",
					"desc" => "Tick to display",
					"id" => "top-google-map",
					"std" => "1",
					"type" => "checkbox");
					
$of_options[] = array( "name" => 'Display Google Map On Contact Page',
					"desc" => 'Tick to display',
					"id" => "map_address",
					"std" => "0",
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Google Map Latitude",
					"desc" => "",
					"id" => "gmap-top-lat",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => "Google Map Longitude",
					"desc" => "",
					"id" => "gmap-top-lng",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => "Google Map Marker Content",
					"desc" => 'You must escape double quotation marks by using a backslash, e.g. for a link you need to write: &lt;a href=\"page.html\"&gt;Link&lt;/a&gt;',
					"id" => "gmap-top-content",
					"std" => "<h2>Nice Hotel</h2><p>1 Main Road, London, UK</p>",
					"type" => "textarea");
					
// Accommodation Options
$of_options[] = array( "name" => "Accommodation Settings",
						"type" => "heading");

$of_options[] = array( "name" => "Currency Unit",
					"desc" => "e.g. $",
					"id" => "currency_unit",
					"std" => "$",
					"type" => "text");
					
$of_options[] = array( "name" => "Booking Page URL",
					"desc" => 'Enter the full URL of the booking page here, e.g. "http://website.com/booking"',
					"id" => "booking_page_url",
					"std" => "",
					"type" => "text");
					
$of_options[] = array( "name" => "Display Room Price on Booking Page",
					"desc" => "Tick to display",
					"id" => "room_price_display",
					"std" => "1",
					"type" => "checkbox");
					
$of_options[] = array( "name" => "Number of Rooms Shown Per Page",
					"desc" => "",
					"id" => "accom_items_per_page",
					"std" => "6",
					"type" => "text");
					
$of_options[] = array( "name" => "Booking Form Success Message",
					"desc" => "Message Shown to Customers After Successfully Booking a Room",
					"id" => "accom_success_msg",
					"std" => "Booking Successful! We will reply within 24 hours",
					"type" => "text");
					
// Photo Gallery Options
$of_options[] = array( "name" => "Photo Settings",
					"type" => "heading");

$of_options[] = array( "name" => "Display Lightbox as an Album",
					"desc" => "Tick to set as an album, this allows you to switch between photos in the lightbox popup",
					"id" => "lightbox_album",
					"std" => "0",
					"type" => "checkbox");
					
// Backup Options
$of_options[] = array( "name" => "Backup Options",
					"type" => "heading");
					
$of_options[] = array( "name" => "Backup and Restore Options",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);
					
	}
}
?>
