<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'controls')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';

/* handle commands */
switch( $cmd ){
	case 'deleteControl':
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
if( ($controls = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetAllControls',array() ) ) ){
	foreach( $controls as $key=>$value ){
		/* do delete and edit commands */
		$controlSkin = $__APPLICATION_['channel']->getSkin('controls-control.tpl');
		$controlCommands = array();
		array_push($controlCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editcontrol',array('sys_control_id'=>$value['sys_control_id']))));
		array_push($controlCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletecontrol',array('sys_control_id'=>$value['sys_control_id']))));
		$controlSkin->replaceLoop('commands',$controlCommands);
		$controlSkin->replace('<var:name>',$value['name']);
		/* check for image else use default */
		$iconName = 'control';
		if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-control.gif') ){
			$iconName = 'default';
		}
		$controlSkin->replace('<var:iconName>',$iconName);
		$controls[$key]['output'] = $controlSkin->output();
	}
}

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('controls',$controls);


/* show channel */
$__APPLICATION_['channel']->show();
?>
