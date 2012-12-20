<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'editcommand')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_channel_id = isSet($_REQUEST['sys_channel_id']) && $_REQUEST['sys_channel_id']!='' ? $_REQUEST['sys_channel_id'] : 0;
$sys_command_id = isSet($_REQUEST['sys_command_id']) && $_REQUEST['sys_command_id']!='' ? $_REQUEST['sys_command_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : 'new';
$name = isSet($_REQUEST['name']) && $_REQUEST['name']!='' ? $_REQUEST['name'] : '';
$displayName = isSet($_REQUEST['displayName']) && $_REQUEST['displayName']!='' ? $_REQUEST['displayName'] : '';
$url = isSet($_REQUEST['url']) && $_REQUEST['url']!='' ? $_REQUEST['url'] : '';
$skin = isSet($_REQUEST['skin']) && $_REQUEST['skin']!='' ? $_REQUEST['skin'] : '';
$description = isSet($_REQUEST['description']) && $_REQUEST['description']!='' ? $_REQUEST['description'] : '';

/* do cmd bit */
switch( $cmd ){
	case 'update':
	    if( $sys_command_id!=0 && $sys_channel_id!=0 ){
	    	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQUpdateCommand',array('name'=>$name,'displayName'=>$displayName,'description'=>$description,'url'=>$url,'skin'=>$skin,'sys_channel_id'=>$sys_channel_id,'sys_command_id'=>$sys_command_id));
	    }
	break;
	case 'new':
	    if( $name!='' && $displayName!='' ){
	    	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQAddCommand',array('name'=>$name,'displayName'=>$displayName,'description'=>$description,'url'=>$url,'skin'=>$skin,'sys_channel_id'=>$sys_channel_id));
	    	$sys_command_id = $__APPLICATION_['database']->__lastID_();
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

/* get section detail */
if( $sys_command_id != 0 ){
	/* get group details */
	if( ($commandDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','CQGetCommandDetail',array('sys_command_id'=>$sys_command_id)) ) ){
		$cmd = 'update';
		$name = $commandDetail['name'];
		$url = $commandDetail['url'];
		$skin = $commandDetail['skin'];
		$displayName = $commandDetail['displayName'];
		$description = $commandDetail['description'];
	}
}

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:sys_channel_id>',$sys_channel_id);
$__APPLICATION_['channel']->replace('<var:sys_command_id>',$sys_command_id);
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:name>',$name);
$__APPLICATION_['channel']->replace('<var:skin>',$skin);
$__APPLICATION_['channel']->replace('<var:url>',$url);
$__APPLICATION_['channel']->replace('<var:displayName>',$displayName);
$__APPLICATION_['channel']->replace('<var:description>',$description);


/* show channel */
$__APPLICATION_['channel']->show();
?>
