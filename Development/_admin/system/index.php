<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'channels')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_channel_id = isSet($_REQUEST['sys_channel_id']) && $_REQUEST['sys_channel_id']!='' ? $_REQUEST['sys_channel_id'] : 0;
$sys_section_id = isSet($_REQUEST['sys_section_id']) && $_REQUEST['sys_section_id']!='' ? $_REQUEST['sys_section_id'] : 0;
$sys_command_id = isSet($_REQUEST['sys_command_id']) && $_REQUEST['sys_command_id']!='' ? $_REQUEST['sys_command_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';

/* handle commands */
switch( $cmd ){
	case 'deleteSection':
	    /* check sys_section_id */
	    if( $sys_section_id!=0 ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQDeleteSection',array('sys_section_id'=>$sys_section_id,'sys_channel_id'=>$sys_channel_id));
	    }
	break;
	case 'deleteCommand':
	    /* check sys_command_id */
	    if( $sys_command_id!=0 ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQDeleteCommand',array('sys_command_id'=>$sys_command_id,'sys_channel_id'=>$sys_channel_id));
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

/* get all channels -> sections/commands*/
$channels = $__APPLICATION_['channel']->channelValues['channels'];
foreach( $channels as $key=>$value ){
	if( $sys_channel_id==0 )
	    $sys_channel_id = $value['sys_channel_id'];
	$channels[$key]['url'] = '<var:adminPath>/system/?sys_channel_id='.$value['sys_channel_id'];
	if( $value['sys_channel_id'] == $sys_channel_id ){
		$channels[$key]['displayName'] = '<b>'.$value['displayName'].'</b>';
	}
}

/* do selected channel */
$cpChannelSkin = $__APPLICATION_['channel']->getSkin('channels-channel.tpl');

/* do commands and replace them in the skin */
$channelCommands = array();
array_push($channelCommands,array('output'=>$__APPLICATION_['channel']->getCommand('addchannel',array())));
array_push($channelCommands,array('output'=>$__APPLICATION_['channel']->getCommand('addsection',array('sys_channel_id'=>$sys_channel_id))));
array_push($channelCommands,array('output'=>$__APPLICATION_['channel']->getCommand('addcommand',array('sys_channel_id'=>$sys_channel_id))));

/* get the channel sections */
if( ($sections = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetSections',array('sys_channel_id'=>$sys_channel_id) ) ) ){
	foreach( $sections as $key=>$value ){
		/* do delete and edit commands */
		$sectionSkin = $__APPLICATION_['channel']->getSkin('channels-section.tpl');
		$sectionCommands = array();
		array_push($sectionCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editsection',array('sys_section_id'=>$value['sys_section_id'],'sys_channel_id'=>$value['sys_channel_id']))));
		array_push($sectionCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletesection',array('sys_section_id'=>$value['sys_section_id'],'sys_channel_id'=>$value['sys_channel_id']))));
		$sectionSkin->replaceLoop('commands',$sectionCommands);
		$sectionSkin->replace('<var:displayName>',$value['displayName']);
		$sections[$key]['output'] = $sectionSkin->output();
	}
	$cpChannelSkin->replaceLoop('channelSections',$sections);
}
/* get the channel commands */
if( ($commandsList = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetCommands',array('sys_channel_id'=>$sys_channel_id) ) ) ){
	foreach( $commandsList as $key=>$value ){
		/* do delete and edit commands */
		$commandsSkin = $__APPLICATION_['channel']->getSkin('channels-command.tpl');
		$commandCommands = array();
		array_push($commandCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editcommand',array('sys_command_id'=>$value['sys_command_id'],'sys_channel_id'=>$value['sys_channel_id']))));
		array_push($commandCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletecommand',array('sys_command_id'=>$value['sys_command_id'],'sys_channel_id'=>$value['sys_channel_id']))));
		$commandsSkin->replaceLoop('commands',$commandCommands);
		$commandsSkin->replace('<var:displayName>',$value['displayName']);
		$commandsList[$key]['output'] = $commandsSkin->output();
	}
	$cpChannelSkin->replaceLoop('channelCommands',$commandsList);
}

$cpChannelSkin->replaceLoop('commands',$channelCommands);

$channelOutput = $cpChannelSkin->output();


/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('channels',$channels);
$__APPLICATION_['channel']->replace('<var:channelOutput>',$channelOutput);


/* show channel */
$__APPLICATION_['channel']->show();
?>
