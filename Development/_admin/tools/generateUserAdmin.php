<?php

require_once(".citadel.config.conf");

$items = $GLOBALS['__APPLICATION_']['utilities']->getContentLocations("page");

// TODO: check that we dont have an admuin already

// generate admin section
$admin_tree_id = $GLOBALS['__APPLICATION_']['utilities']->createAndAddModule( $GLOBALS['__APPLICATION_']['site_tree_id'], "Admin", 'page', array('path'=>'admin','restrictedTo'=>'1','isAuthorized'=>'yes','showInMenu'=>'yes'),true,true );
  
// generate pages section
$page_tree_id = $GLOBALS['__APPLICATION_']['utilities']->createAndAddModule( $admin_tree_id, "Pages", 'page', array('path'=>'pages','restrictedTo'=>'1','isAuthorized'=>'yes','showInMenu'=>'yes'),true,true );  

// generate pages section
$content_tree_id = $GLOBALS['__APPLICATION_']['utilities']->createAndAddModule( $admin_tree_id, "Content", 'page', array('path'=>'content','restrictedTo'=>'1','isAuthorized'=>'yes','showInMenu'=>'yes'),true,true );  
  
foreach( $items as $key=>$value ){

  // generate include, loop 
  
//  $pages_include_tree_id = $GLOBALS['__APPLICATION_']['utilities']->createAndAddModule( $admin_tree_id, "Pages", 'page', array('path'=>'pages','restrictedTo'=>'1','isAuthorized'=>'yes','showInMenu'=>'yes') );    

  // generate skin, loop

  // generate generate edit page

  // generate include , edit

  // generate skin, loop

    
}

// generate all editable content

  // generate pages section

  // generate include, loop 

  // generate skin, loop

  // generate generate edit page

  // generate include , edit

  // generate skin, loop
//


?>
