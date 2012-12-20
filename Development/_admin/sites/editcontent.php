<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'editcontent')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$sys_component_id = isSet($_REQUEST['sys_component_id']) ? $_REQUEST['sys_component_id'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$mod_content_id = isSet($_REQUEST['mod_content_id']) ? $_REQUEST['mod_content_id'] : 0;
$sys_field_type_id = isSet($_REQUEST['sys_field_type_id']) ? $_REQUEST['sys_field_type_id'] : 1;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';

/* do the module save */
if( $cmd != '' ){
    $module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id)),'setContent');
}else{
	$cmd = 'edit';
}

//$moduleDetails = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','MQGetTreeDetail',array('sys_module_id'=>$sys_module_id));

/* do commands bit */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editcontent',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('previewmodule',array('sys_tree_id'=>$sys_tree_id))));

$module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'sys_field_type_id'=>$sys_field_type_id)),'admin');

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('subCommands',$subCommands);
$__APPLICATION_['channel']->replace('<var:moduleOutput>',$module->output());
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:sys_tree_id>',$sys_tree_id);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:sys_component_id>',$sys_component_id);
$__APPLICATION_['channel']->replace('<var:mod_content_id>',$mod_content_id);

/* show channel */
$__APPLICATION_['channel']->show();
?>