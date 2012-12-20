<?
ob_start();
// get all vars
require_once(".citadel.config.conf");
$existing = 0;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$session = isSet($_REQUEST['session']) ? $_REQUEST['session'] : '';
$currentPath = isSet($_REQUEST['currentPath']) ? $_REQUEST['currentPath'] : '';
$pagePath = isSet($_REQUEST['pagePath']) ? $_REQUEST['pagePath'] : '';
$module_id = isSet($_REQUEST['module_id']) ? $_REQUEST['module_id'] : $module_id;

$module_content_id = isSet($_REQUEST['module_content_id']) ? $_REQUEST['module_content_id'] : '';


$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : $tableName;

$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : '';


$overideChannelSkinName = isSet($_REQUEST['overideChannelSkinName']) ? $_REQUEST['overideChannelSkinName'] : '';
$overideSkinName = isSet($_REQUEST['overideSkinName']) ? $_REQUEST['overideSkinName'] : '';
$title = isSet($_REQUEST['title']) ? $_REQUEST['title'] : '';
$overideSkinPath = isSet($_REQUEST['overideSkinPath']) || $overideSkinName!='' ? 'clients'.$__CONFIG_['__paths_']['__clientPath_'].'/skins' : '';

$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'www','skin'=>$overideChannelSkinName)));
if( isSet($module_content_id) && $module_content_id!='' ){
	$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$module_content_id,'tableName'=>$tableName,'skinName'=>$overideSkinName,'skinPath'=>$overideSkinPath,'editMode'=>0,'currentPath'=>$currentPath,'nextElementEditMode'=>'yes')),$cmd);
}else{
	$module = new module(array('in'=>array('sys_tree_id'=>$module_id,'skinName'=>$overideSkinName,'skinPath'=>$overideSkinPath,'editMode'=>0,'currentPath'=>$currentPath,'nextElementEditMode'=>'yes')),$cmd);
}
$__APPLICATION_['channel']->channelReplace('<var:output>',$module->output());
$__APPLICATION_['channel']->channelReplace('<var:pagePath>',$pagePath);
$__APPLICATION_['channel']->channelReplace('<var:title>',$title);
ob_end_clean();
$__APPLICATION_['channel']->show();
?>
