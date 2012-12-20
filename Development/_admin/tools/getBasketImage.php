<?
require_once(".citadel.config.conf");

// resolve request var
$sys_tree_id = $_REQUEST['sys_tree_id'];

// get the module
$module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id)),'');

// count children and return the right image
$numberOfChildren = count($module->moduleValues['skinFunctions']['loop']['children']);
$imageName = '';
if( $numberOfChildren <=4 ){
	$imageName = 'eye_green.gif';
}else if($numberOfChildren <=9 ){
	$imageName = 'eye_blue.gif';
}else if($numberOfChildren <=14 ){
	$imageName = 'eye_yellow.gif';
}else{
	$imageName = 'eye_red.gif';
}

//echo $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/images/'.$imageName;
/* resolve get var imagePath */
$imagePath = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/images/'.$imageName;
$binary_junk = $__APPLICATION_['utilities']->bs_file($imagePath);
$type = explode('.',$imagePath);
$type = $type[1];
header("Content-type: ".$__APPLICATION_['utilities']->getMimeType($type));
echo $binary_junk;
?>