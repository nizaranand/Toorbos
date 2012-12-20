<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'previewmodule')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;

/* do commands bit */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('previewmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('export',array('sys_tree_id'=>$sys_tree_id))));

$module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id)),'');

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:modulePreview>',$module->output());

/* show channel */
$__APPLICATION_['channel']->show();
?>