<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'editsection')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_channel_id = isSet($_REQUEST['sys_channel_id']) && $_REQUEST['sys_channel_id']!='' ? $_REQUEST['sys_channel_id'] : 0;
$sys_section_id = isSet($_REQUEST['sys_section_id']) && $_REQUEST['sys_section_id']!='' ? $_REQUEST['sys_section_id'] : 0;
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : 'new';
$name = isSet($_REQUEST['name']) && $_REQUEST['name']!='' ? $_REQUEST['name'] : '';
$displayName = isSet($_REQUEST['displayName']) && $_REQUEST['displayName']!='' ? $_REQUEST['displayName'] : '';
$description = isSet($_REQUEST['description']) && $_REQUEST['description']!='' ? $_REQUEST['description'] : '';

/* do cmd bit */
switch( $cmd ){
	case 'update':
	    if( $sys_section_id!=0 && $sys_channel_id!=0 ){
	    	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQUpdateSection',array('name'=>$name,'displayName'=>$displayName,'description'=>$description,'sys_channel_id'=>$sys_channel_id,'sys_section_id'=>$sys_section_id));
	    }
	break;
	case 'new':
	    if( $name!='' && $displayName!='' ){
	    	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','SQAddSection',array('name'=>$name,'displayName'=>$displayName,'description'=>$description,'sys_channel_id'=>$sys_channel_id));
	    	$sys_section_id = $__APPLICATION_['database']->__lastID_();
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
if( $sys_section_id != 0 ){
	/* get group details */
	if( ($sectionDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','SQGetSectionDetail',array('sys_section_id'=>$sys_section_id)) ) ){
		$cmd = 'update';
		$name = $sectionDetail['name'];
		$displayName = $sectionDetail['displayName'];
		$description = $sectionDetail['description'];
	}
}

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:sys_channel_id>',$sys_channel_id);
$__APPLICATION_['channel']->replace('<var:sys_section_id>',$sys_section_id);
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:name>',$name);
$__APPLICATION_['channel']->replace('<var:displayName>',$displayName);
$__APPLICATION_['channel']->replace('<var:description>',$description);


/* show channel */
$__APPLICATION_['channel']->show();
?>
