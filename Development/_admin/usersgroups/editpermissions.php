<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'usersgroups','section'=>'editpermissions')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* set user to nice */
$userDetail = $__APPLICATION_['session']->user->getUserDetail();

/* set default channel */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$sys_group_id = isSet($_REQUEST['sys_group_id']) && $_REQUEST['sys_group_id']!='' ? $_REQUEST['sys_group_id'] : 0;
$sys_user_id = isSet($_REQUEST['sys_user_id']) && $_REQUEST['sys_user_id']!='' ? $_REQUEST['sys_user_id'] : 0;
$sys_user_id = isSet($_REQUEST['sys_user_id']) && $_REQUEST['sys_user_id']!='' ? $_REQUEST['sys_user_id'] : 0;
$sys_channel_id = isSet($_REQUEST['sys_channel_id']) && $_REQUEST['sys_channel_id']!='' ? $_REQUEST['sys_channel_id'] : 1;
$sys_section_id = isSet($_REQUEST['sys_section_id']) && $_REQUEST['sys_section_id']!='' ? $_REQUEST['sys_section_id'] : 0;

/* do update of permissions */
if( $cmd == 'update' ){
	/* remove all references for this channel */
	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQClearPermissions',array('sys_channel_id'=>$sys_channel_id));
	foreach( $_REQUEST as $key=>$value ){
		/* check for channel update */
		if( strstr($key,'channelperm-'.$sys_channel_id) ){
			if( $value == '1' ){
				/* insert a channel restriction */
				$usergroupColumn = $sys_user_id!=0 ? 'sys_user_id' : 'sys_group_id';
				$usergroupValue = $sys_user_id!=0 ? $sys_user_id : $sys_group_id;
//				echo $__APPLICATION_['database']->__getQueryByCode_('CQSetRestriction',array('columns'=>$usergroupColumn.',sys_channel_id','values'=>$usergroupValue.','.$sys_channel_id));
                $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQSetRestriction',array('columns'=>$usergroupColumn.',sys_channel_id','values'=>$usergroupValue.','.$sys_channel_id));
			}
		}
		if( strstr($key,'sectionperm-'.$sys_section_id) ){
			if( $value == '1' ){
				/* insert a section restriction */
			    $usergroupColumn = $sys_user_id!=0 ? 'sys_user_id' : 'sys_group_id';
				$usergroupValue = $sys_user_id!=0 ? $sys_user_id : $sys_group_id;
                $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQSetRestriction',array('columns'=>$usergroupColumn.',sys_channel_id,sys_section_id','values'=>$usergroupValue.','.$sys_channel_id.','.$sys_section_id));
			}
		}
		if( strstr($key,'commandperm-') ){
			if( $value == '1' ){
				/* get command id */
				$sys_command_id = str_replace('commandperm-','',$key);
				/* insert a command restriction */
			    $usergroupColumn = $sys_user_id!=0 ? 'sys_user_id' : 'sys_group_id';
				$usergroupValue = $sys_user_id!=0 ? $sys_user_id : $sys_group_id;
                $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQSetRestriction',array('columns'=>$usergroupColumn.',sys_channel_id,sys_section_id,sys_command_id','values'=>$usergroupValue.','.$sys_channel_id.','.$sys_section_id.','.$sys_command_id));
			}
		}
	}
}

/* set vars for current channel and section */
$channel = array();
$section = array();

/* get channels */
if( $channels = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetChannels',array()) ){
	foreach( $channels as $key=>$value ){
		if( $value['sys_channel_id'] == $sys_channel_id ){
			$channels[$key]['name'] = '<b>'.$value['name'].'</b>';
			$channel['name'] = $channels[$key]['name'];
			$channel['sys_channel_id'] = $channels[$key]['sys_channel_id'];
			$channel['sys_user_id'] = $sys_user_id;
			$channel['sys_group_id'] = $sys_group_id;
			/* get the channel user/group selection value */
			if( $sys_user_id!=0 ){
				if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','UQGetChannelPermissions',array('sys_user_id'=>$sys_user_id,'sys_channel_id'=>$sys_channel_id,'sys_section_id'=>0,'sys_command_id'=>0)) ){
				    $channel['selected'] = 'checked';
				}
			}
			if( $sys_group_id!=0 ){
				if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetChannelPermissions',array('sys_group_id'=>$sys_group_id,'sys_channel_id'=>$sys_channel_id,'sys_section_id'=>0,'sys_command_id'=>0)) ){
				    $channel['selected'] = 'checked';
				}				
			}
			if( !isSet( $channel['selected'] ) ){
				$channel['selected'] = '';
			}
		}
	}
}

/* get sections */
if( $sections = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetSections',array('sys_channel_id'=>$sys_channel_id)) ){
	foreach( $sections as $key=>$value ){
		/* if section id not set set to first one */
		if( $sys_section_id==0 )
		    $sys_section_id = $value['sys_section_id'];
		    
		if( $value['sys_section_id'] == $sys_section_id ){
			$section['name'] = $value['name'];
			$section['sys_section_id'] = $value['sys_section_id'];
			$section['sys_user_id'] = $sys_user_id;
			$section['sys_group_id'] = $sys_group_id;
			/* get the channel user/group selection value */
			if( $sys_user_id!=0 ){
				if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','UQGetChannelPermissions',array('sys_user_id'=>$sys_user_id,'sys_channel_id'=>$sys_channel_id,'sys_section_id'=>$sys_section_id,'sys_command_id'=>0)) ){
				    $section['selected'] = 'checked';
				}
			}
			if( $sys_group_id!=0 ){
				if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetChannelPermissions',array('sys_group_id'=>$sys_group_id,'sys_channel_id'=>$sys_channel_id,'sys_section_id'=>$sys_section_id,'sys_command_id'=>0)) ){
				    $section['selected'] = 'checked';
				}
			}
			if( !isSet( $section['selected'] ) ){
				$section['selected'] = '';
			}
		}
			
		$sections[$key]['sys_channel_id'] = $sys_channel_id;
	}
}

/* get commands */
/* get sections */
if( $commands = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetCommands',array('sys_channel_id'=>$sys_channel_id,'sys_section_id'=>$sys_section_id)) ){
	foreach( $commands as $key=>$value ){
		/* get the channel user/group selection value */
		if( $sys_user_id!=0 ){
			if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','UQGetChannelPermissions',array('sys_user_id'=>$sys_user_id,'sys_channel_id'=>$sys_channel_id,'sys_section_id'=>$sys_section_id,'sys_command_id'=>$value['sys_command_id'])) ){
				$commands[$key]['selected'] = 'checked';
			}
		}
		if( $sys_group_id!=0 ){
			if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetChannelPermissions',array('sys_group_id'=>$sys_group_id,'sys_channel_id'=>$sys_channel_id,'sys_section_id'=>$sys_section_id,'sys_command_id'=>$value['sys_command_id'])) ){
				$commands[$key]['selected'] = 'checked';
			}
		}
		if( !isSet( $commands[$key]['selected'] ) ){
			$commands[$key]['selected'] = '';
		}
	}
	
	$sections[$key]['sys_channel_id'] = $sys_channel_id;
}


$__APPLICATION_['channel']->replaceLoop('channels',$channels);
$__APPLICATION_['channel']->replaceLoop('sections',$sections);
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:channelName>',$channel['name']);
$__APPLICATION_['channel']->replace('<var:sys_channel_id>',$channel['sys_channel_id']);
$__APPLICATION_['channel']->replace('<var:channelSelected>',$channel['selected']);
$__APPLICATION_['channel']->replace('<var:sectionName>',$section['name']);
$__APPLICATION_['channel']->replace('<var:sys_section_id>',$section['sys_section_id']);
$__APPLICATION_['channel']->replace('<var:sectionSelected>',$section['selected']);
$__APPLICATION_['channel']->replace('<var:sys_user_id>',$sys_user_id);
$__APPLICATION_['channel']->replace('<var:sys_group_id>',$sys_group_id);
$__APPLICATION_['channel']->replace('<var:cmd>','update');


/* show channel */
$__APPLICATION_['channel']->show();
?>