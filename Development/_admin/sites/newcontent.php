<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'newcontent')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_parent_id = isSet($_REQUEST['sys_parent_id']) ? $_REQUEST['sys_parent_id'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$currentPath = isSet($_REQUEST['currentPath']) ? $_REQUEST['currentPath'] : '';
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';

if( $cmd=='new' ){
	$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'sys_parent_id'=>$sys_parent_id)),'add');
	header("Location: editmodule.php?sys_parent_id=".$sys_parent_id."&sys_module_id=".$sys_module_id."&mod_content_id=".$module->moduleValues['sys']['mod_content_id']."&currentPath=".$currentPath);
}

/* get content options */
$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id)),'admin');

/* replace values */
$__APPLICATION_['channel']->replace('<var:moduleOutput>',$module->output());
$__APPLICATION_['channel']->replace('<var:sys_parent_id>',$sys_parent_id);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:currentPath>',$currentPath);
$__APPLICATION_['channel']->replace('<var:cmd>',($cmd=='' ? 'new' : $cmd));

/* show channel */
$__APPLICATION_['channel']->show();

?>