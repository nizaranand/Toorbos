<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'usersgroups','section'=>'editgroup')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

$messages = $GLOBALS['__APPLICATION_']['messages'];

/* resolve vars */
$sys_group_id = isSet($_REQUEST['sys_group_id']) && $_REQUEST['sys_group_id']!='' ? $_REQUEST['sys_group_id'] : 0;
$groupName = isSet($_REQUEST['groupName']) && $_REQUEST['groupName']!='' ? $_REQUEST['groupName'] : 0;
$linkedModules = isSet($_REQUEST['linkedModules']) && $_REQUEST['linkedModules']!='' ? $_REQUEST['linkedModules'] : 0;
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : 'new';


/* handle commands */
switch( $cmd ){
	case 'new':
	    /* check for at least group name */
	    if( $groupName!='' ){
	    	/* add group and set user id */
	    	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','GQAddGroup',array('name'=>$groupName));
	    	$sys_group_id = $__APPLICATION_['database']->__lastID_();
	    }
	break;
	case 'update':
    	/* update user */
    	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','GQUpdateGroup',array('name'=>$groupName,'sys_group_id'=>$sys_group_id,'linkedModules'=>$linkedModules));
	break;
}


/* check for new or exisitng group */
if( $sys_group_id != 0 ){
	/* get group details */
	if( !($groupDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetGroupDetail',array('sys_group_id'=>$sys_group_id)) ) ){
		$cmd = 'new';
	}else{
		$cmd = 'update';
	}
}

/* get commands */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('addgroup',array())));

/* check editable */
if( isSet($groupDetail['name']) && $groupDetail['name']==$GLOBALS['__APPLICATION_']['session']->user->userDetail['group']['name'] && $GLOBALS['__APPLICATION_']['session']->user->userDetail['group']['name']!='super'){
	$groupPermissionEditable = 0;
}else{
	$groupPermissionEditable = 1;
}

/* get permissioins options */
if( $cmd!='new' && $groupPermissionEditable  ){
  array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editgroupperms',array('sys_group_id'=>$sys_group_id))));
}else{
  array_push($commands,array('output'=>''));
}

/* create replace values by default */
$groupName = isSet($groupDetail) ? $groupDetail['name'] : '';
$linkedModules = isSet($linkedModules) ? $groupDetail['linkedModules'] : '';

/* do controls */
$groupName = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$groupName,'fieldName'=>'groupName','displayName'=>'Name')),'admin');
$groupName = $groupName->output();
$linkedModules = new control(array('in'=>array('sys_control_id'=>4,'system_table'=>'sys_module','fieldValue'=>$linkedModules,'fieldName'=>'linkedModules','displayName'=>'Allowed Modules')),'admin');
$linkedModules = $linkedModules->output();

/* replace values */
//$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:sys_group_id>',$sys_group_id);
$__APPLICATION_['channel']->replace('<var:groupName>',$groupName);
$__APPLICATION_['channel']->replace('<var:linkedModules>',$linkedModules);

/* show channel */
$__APPLICATION_['channel']->show();
?>
