<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'modules')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$tableName = isSet($_REQUEST['tableName']) && $_REQUEST['tableName']!='' ? $_REQUEST['tableName'] : '';
$sys_module_id = isSet($_REQUEST['sys_module_id']) && $_REQUEST['sys_module_id']!='' ? $_REQUEST['sys_module_id'] : '';

/* handle commands */
switch( $cmd ){
	case 'deleteModule':
	    /* check tableName */
	    if( $tableName!='' ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQDeleteModuleTable',array('tableName'=>$tableName));
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQDeleteModuleFieldsTable',array('tableName'=>$tableName));
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQDeleteModule',array('sys_module_id'=>$sys_module_id));
	    }
	break;
}


/* get commands */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('channels',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('modules',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('components',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('controls',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('config',array())));

$listCommands = array();
array_push($listCommands,array('output'=>$__APPLICATION_['channel']->getCommand('newmodule',array())));
array_push($listCommands,array('output'=>$__APPLICATION_['channel']->getCommand('importmodule',array())));

/* get all modules */
if( ($modules = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModules',array() ) ) ){
	foreach( $modules as $key=>$value ){
		/* do delete and edit commands */
		$moduleSkin = $__APPLICATION_['channel']->getSkin('modules-module.tpl');
		$moduleCommands = array();
		array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editmodule',array('sys_module_id'=>$value['sys_module_id']))));
		array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletemodule',array('sys_module_id'=>$value['sys_module_id'],'tableName'=>$value['tableName']))));
		array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('exportmodule',array('sys_module_id'=>$value['sys_module_id']))));
		$moduleSkin->replaceLoop('commands',$moduleCommands);
		$moduleSkin->replace('<var:name>',$value['name']);
		/* check for image else use default */
		if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-'.$value['tableName'].'.gif') ){
			$value['tableName'] = 'default';
		}
		$moduleSkin->replace('<var:tableName>',$value['tableName']);
		$modules[$key]['output'] = $moduleSkin->output();
	}
}

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('commands',$listCommands);
$__APPLICATION_['channel']->replaceLoop('modules',$modules);


/* show channel */
$__APPLICATION_['channel']->show();
?>
