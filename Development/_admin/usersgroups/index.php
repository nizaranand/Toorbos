<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'usersgroups','section'=>'main')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_user_id = isSet($_REQUEST['sys_user_id']) && $_REQUEST['sys_user_id']!='' ? $_REQUEST['sys_user_id'] : 0;
$sys_group_id = isSet($_REQUEST['sys_group_id']) && $_REQUEST['sys_group_id']!='' ? $_REQUEST['sys_group_id'] : '';
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';

/* handle commands */
switch( $cmd ){
	case 'deleteuser':
	    /* check sys_user_id */
	    if( $sys_user_id!=0 ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','UQDeleteUser',array('sys_user_id'=>$sys_user_id));
            $__APPLICATION_['database']->__runQueryByCode_('__runquery_','UQDeleteUserLink',array('sys_user_id'=>$sys_user_id));
	    }
	break;
	case 'deletegroup':
	    /* check sys_group_id */
	    if( $sys_group_id!=0 ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','GQDeleteGroup',array('sys_group_id'=>$sys_group_id));
        	/* delete all users and links */
        	if( !($users = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','GQGetUsersInGroup',array('sys_group_id'=>$sys_group_id)) ) ){
        		//echo "couldn't get group users!";
        	}else{
        		foreach( $users as $key=>$value ){
        			$__APPLICATION_['database']->__runQueryByCode_('__runquery_','UQDeleteUser',array('sys_user_id'=>$value['sys_user_id']));
        			$__APPLICATION_['database']->__runQueryByCode_('__runquery_','UQDeleteUserLink',array('sys_user_id'=>$value['sys_user_id']));
        		}       	    
        	}
	    }
	break;
}

/* get all groups */
if( !($groups = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','GQGetGroups',array()) ) ){
	//echo "couldn't get groups";
}

/* get commands */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('addgroup',array())));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('adduser',array())));

/* replace commands */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);

/* loop through groups, get all users and replace template */
$groupsOutput = '';
foreach( $groups as $key=>$value ){
	if( $value['name'] != 'super' || $GLOBALS['__APPLICATION_']['session']->user->userDetail['group']['name']=='super' ){
		$groupTemplate = $__APPLICATION_['channel']->getSkin('main-group.tpl');
		/* get commands for groups */
		$commands = array();
		array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editgroup',array('sys_group_id'=>$value['sys_group_id']))));
		array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('deletegroup',array('sys_group_id'=>$value['sys_group_id'],'message'=>'Are you sure you want to delete this?'))));
		array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('adduser',array('sys_group_id'=>$value['sys_group_id']))));
		$groupTemplate->replaceLoop('commands',$commands);
		/* get all users in this group */
		$groupTemplate->replace('<var:name>',$value['name']);
		if( !($users = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','GQGetUsersInGroup',array('sys_group_id'=>$value['sys_group_id'])) ) ){
			//echo "couldn't get group users!";
			$groupTemplate->replaceLoop('user',array(0=>array('output'=>'')));
			$groupTemplate->set("");
		}else{
			$userLoop = array();
			foreach( $users as $uKey=>$uValue ){
				$userTemplate = $__APPLICATION_['channel']->getSkin('main-user.tpl');
				/* get commands for users */
				$commands = array();
				array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('edituser',array('sys_group_id'=>$value['sys_group_id'],'sys_user_id'=>$uValue['sys_user_id']))));
				array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('deleteuser',array('sys_group_id'=>$value['sys_group_id'],'sys_user_id'=>$uValue['sys_user_id'],'message'=>'Are you sure you want to delete this?'))));
				$userTemplate->replaceLoop('commands',$commands);
				/* do standard values */
				$userTemplate->replace('<var:username>',$uValue['username']);
				$userTemplate->replace('<var:firstname>',$uValue['firstname']);
				$userTemplate->replace('<var:surname>',$uValue['surname']);
				$userTemplate->replace('<var:email>',$uValue['email']);
				$userTemplate->replace('<var:sys_trash>',($uValue['sys_trash'] ? ' style="text-decoration:line-through;"' : ''));
				array_push($userLoop,array('output'=>$userTemplate->output()));
			}
			$groupTemplate->replaceLoop('user',$userLoop);
		}
		$groupsOutput .= $groupTemplate->output();
	}
}

/* create replacement value */
$__APPLICATION_['channel']->replace('<var:group>',$groupsOutput);


/* show channel */
$__APPLICATION_['channel']->show();
?>
