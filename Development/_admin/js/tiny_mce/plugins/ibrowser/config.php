<?php 
// ================================================
// tinymce PHP WYSIWYG editor control
// ================================================
// Configuration file
// ================================================
// Developed: j-cons.com, mail@j-cons.com
// Copyright: j-cons (c)2004 All rights reserved.
// ------------------------------------------------
//                                   www.j-cons.com
// ================================================
// v.1.0, 2004-10-04
// ================================================
include('../../../../.citadel.config.conf');

// directory where tinymce files are located
$tinyMCE_dir = '/_admin/js/tiny_mce/';

// base url for images
$tinyMCE_base_url = 'http://'.$__CONFIG_['__paths_']['__hostName_'].($__CONFIG_['__paths_']['__httpPath_']!='' ? $__CONFIG_['__paths_']['__urlPath_'] : '/').'';


$tinyMCE_root = $__CONFIG_['__paths_']['__installationPath_'].$tinyMCE_dir;

// image library related config

// allowed extentions for uploaded image files
$tinyMCE_valid_imgs = array('gif', 'jpg', 'jpeg', 'png');

// allow upload in image library
$tinyMCE_upload_allowed = true;

// allow delete in image library
$tinyMCE_img_delete_allowed = true;

// image libraries
$tinyMCE_imglibs = array(
  array(
    'value'   => 'images/',
    'text'    => 'Site Pictures',
  ),
//  array(
//    'value'   => '',
//    'text'    => 'not configured',
//  ),
);
// file to include in img_library.php (useful for setting $tinyMCE_imglibs dynamically
// $tinyMCE_imglib_include = '';
?>