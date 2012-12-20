<?php

function title_shortcode( $atts, $content = null ) {
	
	$output = '';
	$output .= '<h3 class="title1">';
	$output .= $content;
	$output .= '<span class="title-end"></span></h3>';
	
	return $output;

}

add_shortcode( 'title', 'title_shortcode' );

?>