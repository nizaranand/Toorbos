<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'content','section'=>'main')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$tableName = isSet($_REQUEST['tableName']) && $_REQUEST['tableName']!='' ? $_REQUEST['tableName'] : '';

/* do cmd bit */
switch( $cmd ){
	case "deleteModuleContent":
        $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQDeleteAllContent',array('tableName'=>$tableName));
	break;
}

/* get all modules */
if( ($modules = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModules',array() ) ) ){
	foreach( $modules as $key=>$value ){
		/* do delete and edit commands */
		$moduleSkin = $__APPLICATION_['channel']->getSkin('main-module.tpl');
		$moduleCommands = array();
        array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('newcontent',array('sys_module_id'=>$value['sys_module_id'],'tableName'=>$value['tableName']),'commandedit.tpl')));
		array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('listcontent',array('sys_module_id'=>$value['sys_module_id'],'tableName'=>$value['tableName']))));
		array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletemodule',array('sys_module_id'=>$value['sys_module_id'],'tableName'=>$value['tableName']))));
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
$__APPLICATION_['channel']->replaceLoop('modules',$modules);

/* show channel */
$__APPLICATION_['channel']->show();
?>
