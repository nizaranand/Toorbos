<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'sites','section'=>'editcontent')));
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
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : 'new';
$sys_field_type_id = isSet($_REQUEST['sys_field_type_id']) ? $_REQUEST['sys_field_type_id'] : 1;

/* do cmd bit */
switch( $cmd ){
	case "new":
	    if( isSet($sys_parent_id) && $sys_parent_id!=0 && isSet($mod_content_id) && $mod_content_id!=0 && isSet($sys_module_id) && $sys_module_id!=0 ){
	       $module = new module(array('in'=>array('mod_content_id'=>$mod_content_id,'sys_module_id'=>$sys_module_id,'sys_parent_id'=>$sys_parent_id,'currentPath'=>$currentPath,'sys_field_type_id'=>$sys_field_type_id)),'addToTree');
	       $sys_tree_id = $module->moduleValues['sys']['sys_tree_id'];
	       /* do inline commands bit */
	       $inlineCommands = array();
	       array_push($inlineCommands,array('output'=>$__APPLICATION_['channel']->getCommand('addAnother',array('sys_tree_id'=>$sys_parent_id,'currentPath'=>$currentPath),'command.tpl')) );
	    }
	break;
	case "update":
	    $setValues = array('sys_tree_id'=>$sys_tree_id,'sys_module_id'=>$sys_module_id,'sys_parent_id'=>$sys_parent_id,'mod_content_id'=>$mod_content_id,'sys_skin_id'=>$sys_skin_id);
        $module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>$currentPath,'sys_field_type_id'=>$sys_field_type_id)),'setContent');
        $module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>$currentPath,'sys_field_type_id'=>$sys_field_type_id),'setValues'=>$setValues),'setValues');
        /* update published */
        $__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQUpdatePublished',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id,'published'=>$published));
        /* update create cache */
        //$__APPLICATION_['database']->__runQueryByCode_('__runquery_','CQUpdateCreateCache',array('tableName'=>$tableName,'mod_content_id'=>$mod_content_id,'createCache'=>$createCache));
        /* do javascript to refresh window */
        echo '
            <script language="javascript">
               if( window.opener ){
                  var href = window.opener.location.href.split("?");
                  window.opener.location.href = href[0];
               }
            </script>
        ';
	break;
}

/* if not inline commands se to nothing */
$inlineCommands = !isSet($inlineCommands) ? array() : $inlineCommands;

/* create our options array */
$options = array();

/* do commands bit */
$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('editmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('previewmodule',array('sys_tree_id'=>$sys_tree_id))));
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('export',array('sys_tree_id'=>$sys_tree_id))));

/* get module detail */
if( $moduleValues = $__APPLICATION_['database']->__runQueryByCode_( 'fetchrownamed','MQGetTreeDetail',array('sys_tree_id'=>$sys_tree_id )) ){
    $sys_component_id = $moduleValues['sys_component_id'];
    $sys_module_id = $moduleValues['sys_module_id'];
    $mod_content_id = $moduleValues['mod_content_id'];
    $sys_parent_id = $moduleValues['sys_parent_id'];
    $sys_skin_id = $moduleValues['tree_skin_id'];
    $cmd = 'update';
}

// get field types
if( !($fieldTypes = $__APPLICATION_['database']->__runQueryByCode_('fetcharray','FQGetFieldTypes',array('tableName'=>$moduleValues['tableName'])) ) ){
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

/* do tree options by default */
/* check if this user can select a skin */
if( $__APPLICATION_['channel']->getCommand('selectskin') ){
	/* current skin id */
	$sys_skin_id = isSet($moduleValues['tree_skin_id']) ? $moduleValues['tree_skin_id'] : 0;
	/* initiate control for skin selection */
	$skinDropdown = new control(array('in'=>array('sys_control_id'=>3,'system_table'=>'sys_skin','fieldValue'=>$sys_skin_id,'fieldName'=>'sys_skin_id','displayName'=>'Select Skin','sys_module_id'=>$sys_module_id)),'admin');
	array_push($options,array('output'=>$skinDropdown->output()));
}

$module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'sys_field_type_id'=>$sys_field_type_id)),'admin');

/* check if this user can publish and unpublish */
$publishCmd = isSet($module->moduleValues['content']['published']) && $module->moduleValues['content']['published'] ? 'unpublish' : 'publish';
if( $__APPLICATION_['channel']->getCommand($publishCmd.'Content') ){
	/* current value */
	$published = $module->moduleValues['content']['published'];
	/* initiate control for skin selection */
	$publishRadio = new control(array('in'=>array('sys_control_id'=>10,'options'=>array('yes'=>1,'no'=>0),'fieldValue'=>$published,'fieldName'=>'published','displayName'=>'Publish','mod_content_id'=>$mod_content_id)),'admin');
	array_push($options,array('output'=>$publishRadio->output()));
}
/* check if this user can cache and nocache */
//$createCacheCmd = isSet($module->moduleValues['content']['createCache']) && $module->moduleValues['content']['createCache'] ? 'nocache' : 'cache';
//if( $__APPLICATION_['channel']->getCommand($createCacheCmd.'Content') ){
	/* current value */
	//$createCache = $module->moduleValues['content']['createCache'];
	/* initiate control for skin selection */
	//$cacheRadio = new control(array('in'=>array('sys_control_id'=>10,'options'=>array('yes'=>1,'no'=>0),'fieldValue'=>$createCache,'fieldName'=>'createCache','displayName'=>'Create Cache','mod_content_id'=>$mod_content_id)),'admin');
//	array_push($options,array('output'=>$cacheRadio->output()));
//}

$tableName = $module->moduleValues['sys']['tableName'];

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:moduleOutput>',$module->output());

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('commands',$inlineCommands);
$__APPLICATION_['channel']->replaceLoop('options',$options);
$__APPLICATION_['channel']->replaceLoop('subCommands',$subCommands);

$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:moduleUsed>',$moduleUsed);
$__APPLICATION_['channel']->replace('<var:sys_tree_id>',$sys_tree_id);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:sys_component_id>',$sys_component_id);
$__APPLICATION_['channel']->replace('<var:sys_parent_id>',$sys_parent_id);
$__APPLICATION_['channel']->replace('<var:sys_skin_id>',$sys_skin_id);
$__APPLICATION_['channel']->replace('<var:mod_content_id>',$mod_content_id);
$__APPLICATION_['channel']->replace('<var:currentPath>',$currentPath);
$__APPLICATION_['channel']->replace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->replace('<var:sys_field_type_id>',$sys_field_type_id);

/* show channel */
$__APPLICATION_['channel']->show();
?>
