<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'listmodules')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_parent_id = isSet($_REQUEST['sys_parent_id']) ? $_REQUEST['sys_parent_id'] : 0;
$currentPath = isSet($_REQUEST['currentPath']) ? $_REQUEST['currentPath'] : '';

/* initiate parent module to get allowed chidlren */
$parentmodule = new module(array('in'=>array('sys_tree_id'=>$sys_parent_id)),'admin');
$allowedChildren = split(',',$parentmodule->moduleValues['sys']['allowedChildren']);
$disallowedModules = split(',',$__APPLICATION_['session']->user->userDetail['group']['linkedModules']);

/* get all modules */
$actualModules = array();
if( ($modules = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModules',array() ) ) ){
	foreach( $modules as $key=>$value ){
		/* check if allowed */
		if( array_search($value['sys_module_id'],$allowedChildren) && !array_search($value['sys_module_id'],$disallowedModules)){
			/* do delete and edit commands */
			$moduleSkin = $__APPLICATION_['channel']->getSkin('listmodules-module.tpl');
			$moduleCommands = array();
			array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('existingcontent',array('sys_parent_id'=>$sys_parent_id,'sys_module_id'=>$value['sys_module_id'],'tableName'=>$value['tableName'],'currentPath'=>$currentPath))));
			array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('newcontent',array('sys_parent_id'=>$sys_parent_id,'sys_module_id'=>$value['sys_module_id'],'tableName'=>$value['tableName'],'currentPath'=>$currentPath))));
			$moduleSkin->replaceLoop('commands',$moduleCommands);
			$moduleSkin->replace('<var:name>',$value['name']);
			/* check for image else use default */
			if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-'.$value['tableName'].'.gif')){
				$value['tableName'] = 'default';
			}
			$moduleSkin->replace('<var:tableName>',$value['tableName']);
			$actualModules[$key] = array();
			$actualModules[$key]['output'] = $moduleSkin->output();
		}
	}
}

/* replace values */
$__APPLICATION_['channel']->replaceLoop('modules',$actualModules);

/* show channel */
$__APPLICATION_['channel']->show();

?>