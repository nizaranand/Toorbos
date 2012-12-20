<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'usersgroups','section'=>'editgroupperms')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* set user to nice */
$userDetail = $__APPLICATION_['session']->user->getUserDetail();

/* set default channel */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : '';
$sys_group_id = isSet($_REQUEST['sys_group_id']) && $_REQUEST['sys_group_id']!='' ? $_REQUEST['sys_group_id'] : 0;
$sys_channel_id = isSet($_REQUEST['sys_channel_id']) && $_REQUEST['sys_channel_id']!='' ? $_REQUEST['sys_channel_id'] : 1;

/* do update of permissions */
if( $cmd == 'update' ){
	// remove all field values
	$__APPLICATION_['database']->__runquery_('delete from sys_group_permission where sys_type="fields"');
	/* remove all references for this channel */
	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQClearPermissions',array('sys_channel_id'=>$sys_channel_id));
	foreach( $_REQUEST as $key=>$value ){
		/* check for channel update */
		if( strstr($key,'channelperm-'.$sys_channel_id) ){
			if( $value == '1' ){
				/* insert a channel restriction */
                $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQSetGroupRestriction',array('sys_channel_id'=>$sys_channel_id,'sys_group_id'=>$sys_group_id,'sys_id'=>$sys_channel_id,'sys_type'=>'channels'));
			}
		}
		if( strstr($key,'fieldperm-')!='' ){
			if( $value == '1' ){
				$sys_field_type_id = str_replace('fieldperm-','',$key);
				/* insert a channel restriction */
                $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQSetGroupRestriction',array('sys_channel_id'=>0,'sys_group_id'=>$sys_group_id,'sys_id'=>$sys_field_type_id,'sys_type'=>'fields'));
			}
		}

		if( strstr($key,'sectionperm-') ){
			if( $value == '1' ){
				/* get command id */
				$sys_section_id = str_replace('sectionperm-','',$key);
				/* insert a section restriction */
                $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQSetGroupRestriction',array('sys_channel_id'=>$sys_channel_id,'sys_group_id'=>$sys_group_id,'sys_id'=>$sys_section_id,'sys_type'=>'sections'));
			}
		}
		if( strstr($key,'commandperm-') ){
			if( $value == '1' ){
				/* get command id */
				$sys_command_id = str_replace('commandperm-','',$key);
				/* insert a command restriction */
                $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQSetGroupRestriction',array('sys_channel_id'=>$sys_channel_id,'sys_group_id'=>$sys_group_id,'sys_id'=>$sys_command_id,'sys_type'=>'commands'));
			}
		}
	}
}

/* set vars for current channel and section */
$channel = array();

/* get channels */
if( $channels = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetChannels',array()) ){
	foreach( $channels as $key=>$value ){
		if( $value['sys_channel_id'] == $sys_channel_id ){
			$channels[$key]['name'] = '<b>'.$value['name'].'</b>';
			$channel['name'] = $channels[$key]['name'];
			$channel['sys_channel_id'] = $channels[$key]['sys_channel_id'];
			$channel['sys_group_id'] = $sys_group_id;
			/* get the channel user/group selection value */
			if( $sys_group_id!=0 ){
				if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetChannelPermissions',array('sys_group_id'=>$sys_group_id,'sys_channel_id'=>$sys_channel_id,'sys_id'=>$sys_channel_id,'sys_type'=>'channels')) ){
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
		/* get the channel user/group selection value */
		if( $sys_group_id!=0 ){
			if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetChannelPermissions',array('sys_group_id'=>$sys_group_id,'sys_channel_id'=>$sys_channel_id,'sys_id'=>$value['sys_section_id'],'sys_type'=>'sections')) ){
				$sections[$key]['selected'] = 'checked';
			}
		}
		if( !isSet( $sections[$key]['selected'] ) ){
			$sections[$key]['selected'] = '';
		}
	}
}

/* get commands */
if( $commands = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','CQGetCommands',array('sys_channel_id'=>$sys_channel_id)) ){
	foreach( $commands as $key=>$value ){
		/* get the channel user/group selection value */
		if( $sys_group_id!=0 ){
			if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetChannelPermissions',array('sys_group_id'=>$sys_group_id,'sys_channel_id'=>$sys_channel_id,'sys_id'=>$value['sys_command_id'],'sys_type'=>'commands')) ){
				$commands[$key]['selected'] = 'checked';
			}
		}
		if( !isSet( $commands[$key]['selected'] ) ){
			$commands[$key]['selected'] = '';
		}
	}
}


$fieldTypes = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','FQGetFieldTypeItems',array());
foreach( $fieldTypes as $key=>$value ){
	if( $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','GQGetChannelPermissions',array('sys_group_id'=>$sys_group_id,'sys_channel_id'=>0,'sys_id'=>$value['sys_field_type_id'],'sys_type'=>'fields')) ){
		$fieldTypes[$key]['fieldTypeSelected'] = 'checked';
	}else{
		$fieldTypes[$key]['fieldTypeSelected'] = '';
	}
}

$__APPLICATION_['channel']->replaceLoop('channels',$channels);
$__APPLICATION_['channel']->replaceLoop('sections',$sections);
$__APPLICATION_['channel']->replaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('fieldTypes',$fieldTypes);
$__APPLICATION_['channel']->replace('<var:channelName>',$channel['name']);
$__APPLICATION_['channel']->replace('<var:sys_channel_id>',$channel['sys_channel_id']);
$__APPLICATION_['channel']->replace('<var:channelSelected>',$channel['selected']);
$__APPLICATION_['channel']->replace('<var:sys_group_id>',$sys_group_id);
$__APPLICATION_['channel']->replace('<var:cmd>','update');


/* show channel */
$__APPLICATION_['channel']->show();
?>