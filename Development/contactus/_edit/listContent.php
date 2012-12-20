<?
require_once("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'listContent.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_parent_id = isSet($_REQUEST['sys_parent_id']) ? $_REQUEST['sys_parent_id'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$currentPath = isSet($_REQUEST['currentPath']) ? $_REQUEST['currentPath'] : '';
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : '';
$iconTreeURL = isSet($_REQUEST['iconTreeURL']) ? $_REQUEST['iconTreeURL'] : '';

/* get all modules */
if( ($moduleContent = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModuleContent',array('tableName'=>$tableName) ) ) ){
	foreach( $moduleContent as $key=>$value ){
		/* do delete and edit commands */
		$moduleContentSkin = $__APPLICATION_['channel']->getSkin('listcontent-content.tpl');
		$moduleContentCommands = array();
		array_push($moduleContentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('selectcontent',array('sys_parent_id'=>$sys_parent_id,'sys_module_id'=>$sys_module_id,'mod_content_id'=>$value['mod_content_id'],'currentPath'=>$currentPath,'iconTreeURL'=>$iconTreeURL))));
		$moduleContentSkin->replaceLoop('commands',$moduleContentCommands);
		$moduleContentSkin->replace('<var:name>',$value['name']);
		$moduleContent[$key]['output'] = $moduleContentSkin->output();
	}
}

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('moduleContent',$moduleContent);
$__APPLICATION_['channel']->channelReplace('<var:iconTreeURL>',$iconTreeURL);

/* show channel */
$__APPLICATION_['channel']->show();

?>