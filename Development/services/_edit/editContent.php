<?
require_once ("../config/.citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array ('in' => array ('path' => 'sites', 'section' => 'editcontent', 'skin' => 'editContent.tpl')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$sys_tree_id = isSet($_REQUEST['sys_tree_id']) ? $_REQUEST['sys_tree_id'] : 0;
$sys_component_id = isSet($_REQUEST['sys_component_id']) ? $_REQUEST['sys_component_id'] : 0;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : 0;
$mod_content_id = isSet($_REQUEST['mod_content_id']) ? $_REQUEST['mod_content_id'] : 0;
$sys_parent_id = isSet($_REQUEST['sys_parent_id']) ? $_REQUEST['sys_parent_id'] : 0;
$sys_skin_id = isSet($_REQUEST['sys_skin_id']) ? $_REQUEST['sys_skin_id'] : 0;
$currentPath = isSet($_REQUEST['currentPath']) ? $_REQUEST['currentPath'] : '';
$published = isSet($_REQUEST['published']) ? $_REQUEST['published'] : '';
$createCache = isSet($_REQUEST['createCache']) ? $_REQUEST['createCache'] : '';
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : '';
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$pagePath = isSet($_REQUEST['pagePath']) ? $_REQUEST['pagePath'] : '';
$sys_field_type_id = isSet($_REQUEST['sys_field_type_id']) ? $_REQUEST['sys_field_type_id'] : 1;
$iconTreeURL = isSet($_REQUEST['iconTreeURL']) ? $_REQUEST['iconTreeURL'] : '';
$newOne = isSet($_REQUEST['newOne']) ? $_REQUEST['newOne'] : false;
$options = array();

if( $sys_tree_id!=0 && $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id )) ){
    $sys_component_id = $moduleValues['sys_component_id'];
    $sys_module_id = $moduleValues['sys_module_id'];
    $mod_content_id = $moduleValues['mod_content_id'];
    $sys_parent_id = $moduleValues['sys_parent_id'];
    $sys_skin_id = isSet($sys_skin_id) && $sys_skin_id!=0 ? $sys_skin_id : $moduleValues['tree_skin_id'];
    $tableName = $moduleValues['tableName'];
}else if( $sys_tree_id==0 && $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetail',array('sys_module_id'=>$sys_module_id )) ){
    $sys_component_id = $moduleValues['sys_component_id'];
    $sys_module_id = $moduleValues['sys_module_id'];
    $tableName = $moduleValues['tableName'];
}

/* do cmd bit */
switch( $cmd ){
	case "new":
	    if( isSet($sys_parent_id) && $sys_parent_id!=0 && isSet($mod_content_id) && $mod_content_id!=0 && isSet($sys_module_id) && $sys_module_id!=0 ){
	       $module = new module(array('in'=>array('mod_content_id'=>$mod_content_id,'sys_module_id'=>$sys_module_id,'sys_parent_id'=>$sys_parent_id,'currentPath'=>$currentPath,'sys_field_type_id'=>$sys_field_type_id)),'addToTree');
	       $sys_tree_id = $module->moduleValues['sys']['sys_tree_id'];
	       $tableName = $module->moduleValues['sys']['tableName'];
	       /* do inline commands bit */
	       $inlineCommands = array();
	       array_push($inlineCommands,array('output'=>$__APPLICATION_['channel']->getCommand('addAnother',array('sys_tree_id'=>$sys_parent_id,'currentPath'=>$currentPath),'command.tpl')) );
	       $newOne = true;
           $cmd = 'update';
	    }
	break;
	case "update":
	    $setValues = array('sys_tree_id'=>$sys_tree_id,'sys_module_id'=>$sys_module_id,'sys_parent_id'=>$sys_parent_id,'mod_content_id'=>$mod_content_id,'sys_skin_id'=>$sys_skin_id);
        if( $sys_tree_id!=0 ){
          $module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>$currentPath,'sys_field_type_id'=>$sys_field_type_id)),'setContent');
          $module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>$currentPath,'sys_field_type_id'=>$sys_field_type_id),'setValues'=>$setValues),'setValues');
          $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQUpdatePublished',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id,'published'=>$published));
        echo '
            <script language="javascript">' .
            		'
               if( window.top ){
               	  parent.$.fancybox.resize();

                  window.top.loadContent("'.($newOne? $sys_parent_id : $sys_tree_id).'","'.$iconTreeURL.'");
                  //window.opener.location.href = href[0];
               }
            </script>
        ';
        }else{
          $module = new module(array('in'=>array('sys_field_type_id'=>$sys_field_type_id,'sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName)),'setContent');
          $module = new module(array('in'=>array('sys_field_type_id'=>$sys_field_type_id,'sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName)),'setValues');
        echo '
            <script language="javascript">' .
            		'
               if( window.top ){
               		parent.$.fancybox.close();

//                  window.top.loadContent("'.($newOne? $sys_parent_id : $sys_tree_id).'","'.$iconTreeURL.'");
//                  window.top.location.reload();
				  if( window.top.location.href.indexOf("?")>-1 ){
	                  window.top.location.href = window.top.location.href+"&reloaded";				  
				  }else{
	                  window.top.location.href = window.top.location.href+"?reloaded";				  
				  }
                  //window.top.location.href=window.top.location.href+"?reloaded";
               }
            </script>
        ';
        }
        /* update published */
        /* update create cache */
        //$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQUpdateCreateCache',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id,'createCache'=>$createCache));
        /* do javascript to refresh window */
	break;
}

/* get module detail */

if( $sys_tree_id!=0 && $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id )) ){
    $sys_component_id = $moduleValues['sys_component_id'];
    $sys_module_id = $moduleValues['sys_module_id'];
    $mod_content_id = $moduleValues['mod_content_id'];
    $sys_parent_id = $moduleValues['sys_parent_id'];
    $sys_skin_id = isSet($sys_skin_id) && $sys_skin_id!=0 ? $sys_skin_id : $moduleValues['tree_skin_id'];
    $tableName = $moduleValues['tableName'];
    if( $cmd!='new' )  $cmd = 'update';
}else if( $sys_tree_id==0 && $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetModuleDetail',array('sys_module_id'=>$sys_module_id )) ){
    $sys_component_id = $moduleValues['sys_component_id'];
    $sys_module_id = $moduleValues['sys_module_id'];
    $tableName = $moduleValues['tableName'];
    $cmd = 'update';
}

// get field types
if( !($fieldTypes = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','FQGetFieldTypes',array('tableName'=>$tableName)) ) ){
	$fieldTypes = array();
	$subCommands = array();
}else{
	$subCommands = array();
	foreach( $fieldTypes as $key=>$value ){
		if( $GLOBALS['__APPLICATION_']['channel']->checkFieldType($value['sys_field_type_id']) ){
			array_push($subCommands,$value);
		}
	}
}

/* get the module usage */
if( $cmd=='update' && $moduleUsage = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetUsage',array('sys_module_id'=>$moduleValues['sys_module_id'],'mod_content_id'=>$moduleValues['mod_content_id'])) ){
	$moduleUsed = $moduleUsage['count(sys_tree_id)'];
}else{
	$moduleUsed = 0;
}

if( $sys_tree_id!=0 ){
  $module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'sys_field_type_id'=>$sys_field_type_id)),'admin');
}else{
  $module = new module(array('in'=>array('sys_field_type_id'=>$sys_field_type_id,'sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName)),'admin');
}

/* check if this user can select a skin */
if( $sys_tree_id!=0 ){
	if( $__APPLICATION_['channel']->getCommand('selectskin') ){
				
	        /* current skin id */
	        $sys_skin_id = isSet($moduleValues['tree_skin_id']) ? $moduleValues['tree_skin_id'] : 0;
	        /* initiate control for skin selection */
	        $skinDropdown = new control(array('in'=>array('sys_control_id'=>3,'system_table'=>'sys_skin','fieldValue'=>$sys_skin_id,'fieldName'=>'sys_skin_id','displayName'=>'Select Skin','sys_module_id'=>$sys_module_id)),'admin');
	        array_push($options,array('output'=>$skinDropdown->output()));
	}
}else{
  $skinDropdown = '';
}

if( $sys_tree_id!=0 ){
	/* check if this user can publish and unpublish */
	$publishCmd = isSet($module->moduleValues['content']['published']) && $module->moduleValues['content']['published'] ? 'unpublish' : 'publish';
	if( $__APPLICATION_['channel']->getCommand($publishCmd.'Content') ){
	        /* current value */
	        $published = $module->moduleValues['content']['published'];
	        /* initiate control for skin selection */
	        $publishRadio = new control(array('in'=>array('sys_control_id'=>10,'options'=>array('yes'=>1,'no'=>0),'fieldValue'=>$published,'fieldName'=>'published','displayName'=>'Publish','mod_content_id'=>$mod_content_id)),'admin');
	        array_push($options,array('output'=>$publishRadio->output()));
	}
}else{
  $publishRadio = '';
}

$tableName = $module->moduleValues['sys']['tableName'];

/* do commands bit */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('previewmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('export',array('sys_tree_id'=>$sys_tree_id))));

/* replace values */
$__APPLICATION_['channel']->channelReplace('<var:moduleOutput>',$module->output());

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('options',$options);
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->channelReplaceLoop('subCommands',$subCommands);
$__APPLICATION_['channel']->channelReplace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->channelReplace('<var:moduleUsed>',$moduleUsed);
$__APPLICATION_['channel']->channelReplace('<var:sys_tree_id>',$sys_tree_id);
$__APPLICATION_['channel']->channelReplace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->channelReplace('<var:sys_component_id>',$sys_component_id);
$__APPLICATION_['channel']->channelReplace('<var:sys_parent_id>',$sys_parent_id);
$__APPLICATION_['channel']->channelReplace('<var:sys_skin_id>',$sys_skin_id);
$__APPLICATION_['channel']->channelReplace('<var:mod_content_id>',$mod_content_id);
$__APPLICATION_['channel']->channelReplace('<var:currentPath>',$currentPath);
$__APPLICATION_['channel']->channelReplace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->channelReplace('<var:pagePath>',$pagePath);
$__APPLICATION_['channel']->channelReplace('<var:iconTreeURL>',$iconTreeURL);
$__APPLICATION_['channel']->channelReplace('<var:sys_field_type_id>',$sys_field_type_id);
$__APPLICATION_['channel']->channelReplace('<var:newOne>',$newOne);

/* show channel */
$__APPLICATION_['channel']->show();
?>
