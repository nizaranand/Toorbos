<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'components')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';

/* handle commands */
switch( $cmd ){
	case 'deleteComponent':
	    /* check sys_section_id */
	    if( $sys_section_id!=0 ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQDeleteSection',array('sys_section_id'=>$sys_section_id,'sys_channel_id'=>$sys_channel_id));
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


/* get all modules */
if( ($components = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetAllComponents',array() ) ) ){
	foreach( $components as $key=>$value ){
		/* do delete and edit commands */
		$componentSkin = $__APPLICATION_['channel']->getSkin('components-component.tpl');
		$componentCommands = array();
		array_push($componentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editcomponent',array('sys_component_id'=>$value['sys_component_id']))));
		array_push($componentCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletecomponent',array('sys_component_id'=>$value['sys_component_id']))));
		$componentSkin->replaceLoop('commands',$componentCommands);
		$componentSkin->replace('<var:name>',$value['name']);
		/* check for image else use default */
		$iconName = 'component';
		if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-component.gif') ){
			$iconName = 'default';
		}
		$componentSkin->replace('<var:iconName>',$iconName);
		$components[$key]['output'] = $componentSkin->output();
	}
}

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('components',$components);


/* show channel */
$__APPLICATION_['channel']->show();
?>
