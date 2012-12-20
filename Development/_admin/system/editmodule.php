<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'editmodule')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : 'new';
$sys_module_id = isSet($_REQUEST['sys_module_id']) && $_REQUEST['sys_module_id']!='' ? $_REQUEST['sys_module_id'] : '';
$sys_field_id = isSet($_REQUEST['sys_field_id']) && $_REQUEST['sys_field_id']!='' ? $_REQUEST['sys_field_id'] : '';
$tableName = isSet($_REQUEST['tableName']) && $_REQUEST['tableName']!='' ? $_REQUEST['tableName'] : '';
$is_custom = isSet($_REQUEST['is_custom']) && $_REQUEST['is_custom']!='' ? $_REQUEST['is_custom'] : '';
$fieldTableName = isSet($_REQUEST['fieldTableName']) && $_REQUEST['fieldTableName']!='' ? $_REQUEST['fieldTableName'] : '';
$fieldName = isSet($_REQUEST['fieldName']) && $_REQUEST['fieldName']!='' ? $_REQUEST['fieldName'] : '';
$moduleName = isSet($_REQUEST['moduleName']) && $_REQUEST['moduleName']!='' ? $_REQUEST['moduleName'] : '';
$allowedChildren = isSet($_REQUEST['allowedChildren']) && $_REQUEST['allowedChildren']!='' ? $_REQUEST['allowedChildren'] : '';
$sys_component_id = isSet($_REQUEST['sys_component_id']) && $_REQUEST['sys_component_id']!='' ? $_REQUEST['sys_component_id'] : '';
$sys_quicklink = isSet($_REQUEST['sys_quicklink']) && $_REQUEST['sys_quicklink']!='' ? $_REQUEST['sys_quicklink'] : '';
$sys_skin_id = isSet($_REQUEST['sys_skin_id']) && $_REQUEST['sys_skin_id']!='' ? $_REQUEST['sys_skin_id'] : '';

/* handle commands */
switch( $cmd ){
	case 'deleteField':
	    /* check sys_section_id */
	    if( $sys_field_id!='' ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQDeleteField',array('sys_field_id'=>$sys_field_id,'tableName'=>$fieldTableName));
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQDeleteTableField',array('fieldName'=>$fieldName,'tableName'=>$fieldTableName));
	    }
	break;
	case 'update':
	    /* check sys_section_id */
	    if( $moduleName!='' && $tableName!='' && $sys_component_id!='' && $sys_skin_id!='' ){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQUpdateModuleDetail',array('sys_module_id'=>$sys_module_id,'tableName'=>$tableName,'moduleName'=>$moduleName,'sys_component_id'=>$sys_component_id,'sys_skin_id'=>$sys_skin_id,'allowedChildren'=>$allowedChildren,'sys_quicklink'=>$sys_quicklink,'is_custom'=>$is_custom));
	    }
	break;
	case 'new':
	    /* check sys_section_id */
	    if( $moduleName!='' && $tableName!='' && $sys_component_id!='' && $sys_skin_id!='' ){
	    	if( !moduleUtilities::getByTableName($tableName) ){
//	    		echo $__APPLICATION_['database']->__getQueryByCode_('MQAddModule',array('sys_module_id'=>$sys_module_id,'tableName'=>$tableName,'moduleName'=>$moduleName,'sys_component_id'=>$sys_component_id,'sys_skin_id'=>$sys_skin_id,'allowedChildren'=>$allowedChildren,'sys_quicklink'=>$sys_quicklink,'is_custom'=>$is_custom));die;
	        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQAddModule',array('sys_module_id'=>$sys_module_id,'tableName'=>$tableName,'moduleName'=>$moduleName,'sys_component_id'=>$sys_component_id,'sys_skin_id'=>$sys_skin_id,'allowedChildren'=>$allowedChildren,'sys_quicklink'=>$sys_quicklink,'is_custom'=>$is_custom));
	        	$sys_module_id = $__APPLICATION_['database']->__lastID_();
	        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQCreateModuleTable',array('tableName'=>$tableName));
	        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','MQCreateModuleFieldsTable',array('tableName'=>$tableName));
			    if( !moduleUtilities::fieldExists($sys_module_id,'name') ){
					moduleUtilities::createField($sys_module_id,'name','Name','Inputbox','');
				}
	    	}
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

/* check for new module */
$fields = array();
if( $sys_module_id != '' ){
	/* get all module fields */
	$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'sys_field_type_id'=>'1 or sys_field_type_id=2 or sys_field_type_id=3 or sys_field_type_id=4 or sys_field_type_id=5 or sys_field_type_id=6')),'admin');
	//	TODO: NB!!!! make field type varialbe
    $moduleName = $module->moduleValues['sys']['moduleName'];
    $tableName = $module->moduleValues['sys']['tableName'];
    $sys_component_id = $module->moduleValues['sys']['sys_component_id'];
    $sys_skin_id = $module->moduleValues['sys']['module_skin_id'];
    $allowedChildren = $module->moduleValues['sys']['allowedChildren'];
    $sys_quicklink = $module->moduleValues['sys']['sys_quicklink'];
    $is_custom = $module->moduleValues['sys']['is_custom'];
    $cmd = 'update';
	/* set current values */
	if( isSet($module->moduleValues['fields']) ){
		$fields = $module->moduleValues['fields'];
		foreach( $fields as $key=>$value ){
			/* do delete and edit commands */
			$fieldSkin = $__APPLICATION_['channel']->getSkin('editmodule-field.tpl');
			$fieldCommands = array();
			array_push($fieldCommands,array('output'=>$__APPLICATION_['channel']->getCommand('editfield',array('sys_field_id'=>$key,'sys_module_id'=>$sys_module_id))));
			array_push($fieldCommands,array('output'=>$__APPLICATION_['channel']->getCommand('deletefield',array('sys_field_id'=>$value['sys_field_id'],'sys_module_id'=>$sys_module_id,'tableName'=>$module->moduleValues['sys']['tableName'],'fieldName'=>$value['name']))));
			$fieldSkin->replaceLoop('commands',$fieldCommands);
			$fieldSkin->replace('<var:name>',$value['name']);
			/* check for image else use default */
			$fieldIcon = 'field';
			if( !is_file($__CONFIG_['__paths_']['__installationPath_'].'/'.$__CONFIG_['__paths_']['__adminDirectory_'].'/images/tree/icons/icn-field.gif') ){
				$fieldIcon = 'default';
			}
			$fieldSkin->replace('<var:fieldIcon>',$fieldIcon);
			$fields[$key]['output'] = $fieldSkin->output();
		}
	}
}

/* do module detail fields */
$moduleName = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$moduleName,'fieldName'=>'moduleName','displayName'=>'Module Name')),'admin');
$moduleName = $moduleName->output();
$tableName = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$tableName,'fieldName'=>'tableName','displayName'=>'Table Name')),'admin');
$tableName = $tableName->output();
$componentSelect = new control(array('in'=>array('sys_control_id'=>3,'system_table'=>'sys_component','fieldValue'=>$sys_component_id,'fieldName'=>'sys_component_id','displayName'=>'Select Component')),'admin');
$componentSelect = $componentSelect->output();
$skinSelect = new control(array('in'=>array('sys_control_id'=>3,'system_table'=>'sys_skin','fieldValue'=>$sys_skin_id,'fieldName'=>'sys_skin_id','displayName'=>'Default Skin')),'admin');
$skinSelect = $skinSelect->output();
$allowedChildren = new control(array('in'=>array('sys_control_id'=>4,'system_table'=>'sys_module','fieldValue'=>$allowedChildren,'fieldName'=>'allowedChildren','displayName'=>'Allowed Children')),'admin');
$allowedChildren = $allowedChildren->output();
$sys_quicklink = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$sys_quicklink,'fieldName'=>'sys_quicklink','displayName'=>'Show as quicklink?')),'admin');
$sys_quicklink = $sys_quicklink->output();
$is_custom = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$is_custom,'fieldName'=>'is_custom','displayName'=>'Editable by Fiber Lite?')),'admin');
$is_custom = $is_custom->output();


/* do module commands */
$moduleCommands = array();
array_push($moduleCommands,array('output'=>$__APPLICATION_['channel']->getCommand('addfield',array('sys_field_count'=>count($fields),'sys_module_id'=>$sys_module_id))));

/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('moduleCommands',$moduleCommands);
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:moduleName>',$moduleName);
$__APPLICATION_['channel']->replace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->replace('<var:componentSelect>',$componentSelect);
$__APPLICATION_['channel']->replace('<var:skinSelect>',$skinSelect);
$__APPLICATION_['channel']->replace('<var:allowedChildren>',$allowedChildren);
$__APPLICATION_['channel']->replace('<var:sys_quicklink>',$sys_quicklink);
$__APPLICATION_['channel']->replace('<var:is_custom>',$is_custom);
$__APPLICATION_['channel']->replaceLoop('fields',$fields);


/* show channel */
$__APPLICATION_['channel']->show();
?>
