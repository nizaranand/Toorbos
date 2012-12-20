<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'skins','section'=>'main')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$sys_skin_id = isSet($_REQUEST['sys_skin_id']) && $_REQUEST['sys_skin_id']!='' ? $_REQUEST['sys_skin_id'] : '';

/* do cmd bit */
switch( $cmd ){
	case "deleteSkin":
        $__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQDeleteSkin',array('sys_skin_id'=>$sys_skin_id));
	break;
}

$listCommands = array();
array_push($listCommands,array('output'=>$__APPLICATION_['channel']->getCommand('newskin',array())));
$oneSkin =  false;
/* get all modules */
if( ($modulesTemp = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','MQGetAllModules',array() ) ) ){
    $modules = array();
	foreach( $modulesTemp as $key=>$value ){
		if( $__APPLICATION_['database']->__runQueryByCode_('fetcharray','SQGetAssociatedSkins',array('sys_module_id'=>$value['sys_module_id'])) ){
			/* do delete and edit commands */
			$moduleSkin = $__APPLICATION_['channel']->getSkin('main-module.tpl');
			$moduleCommands = array();
			array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('selectmodule',array('sys_module_id'=>$value['sys_module_id']))));
			$moduleSkin->replaceLoop('commands',$moduleCommands);
			$moduleSkin->replace('<var:name>',$value['name']);
			/* check for image else use default */
			if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-'.$value['tableName'].'.gif') ){
				$value['tableName'] = 'default';
			}
			$moduleSkin->replace('<var:tableName>',$value['tableName']);
			array_push($modules,array('output'=>$moduleSkin->output()));
			$oneSkin = true;
		}
	}
}

if( !$oneSkin ){
	$modules = array();
	array_push($modules,array('output'=>'<p class="subDescriptor"><b>There are no skins associated with modules!</b></p>'));
}

/* get all skins */
if( ($skins = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','SQGetUnassociatedSkins',array() ) ) ){
	foreach( $skins as $key=>$value ){
		/* do delete and edit commands */
		$skinsSkin = $__APPLICATION_['channel']->getSkin('main-skin.tpl');
		$skinCommands = array();
		array_push($skinCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editskin',array('sys_skin_id'=>$value['sys_skin_id']))));
		array_push($skinCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deleteskin',array('sys_skin_id'=>$value['sys_skin_id']))));
		$skinsSkin->replaceLoop('commands',$skinCommands);
		$skinsSkin->replace('<var:name>',$value['name']);
		$skinsSkin->replace('<var:description>',$value['description']);
		/* check for image else use default */
		$iconName = 'skin';
		if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-skin.gif') ){
			$iconName = 'default';
		}
		$skinsSkin->replace('<var:iconName>',$iconName);
		$skins[$key]['output'] = $skinsSkin->output();
	}
}else{
	$skins = array();
	array_push($skins,array('output'=>'<p class="subDescriptor"><b>There are no unassociated skins!</b></p>'));
}

/* replace values */
$__APPLICATION_['channel']->replaceLoop('commands',$listCommands);
$__APPLICATION_['channel']->replaceLoop('modules',$modules);
$__APPLICATION_['channel']->replaceLoop('skins',$skins);

/* show channel */
$__APPLICATION_['channel']->show();
?>
