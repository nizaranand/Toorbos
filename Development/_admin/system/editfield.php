<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'system','section'=>'editfield')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$cmd = isSet($_REQUEST['cmd']) && $_REQUEST['cmd']!='' ? $_REQUEST['cmd'] : 'new';
$sys_module_id = isSet($_REQUEST['sys_module_id']) && $_REQUEST['sys_module_id']!='' ? $_REQUEST['sys_module_id'] : '';
$sys_field_id = isSet($_REQUEST['sys_field_id']) && $_REQUEST['sys_field_id']!='' ? $_REQUEST['sys_field_id'] : '';
$sys_field_number = isSet($_REQUEST['sys_field_number']) && $_REQUEST['sys_field_number']!='' ? $_REQUEST['sys_field_number'] : '';
$fieldName = isSet($_REQUEST['fieldName']) && $_REQUEST['fieldName']!='' ? $_REQUEST['fieldName'] : '';
$displayName = isSet($_REQUEST['displayName']) && $_REQUEST['displayName']!='' ? $_REQUEST['displayName'] : '';
$controlValues = isSet($_REQUEST['controlValues']) && $_REQUEST['controlValues']!='' ? $_REQUEST['controlValues'] : '';
$sys_control_id = isSet($_REQUEST['sys_control_id']) && $_REQUEST['sys_control_id']!='' ? $_REQUEST['sys_control_id'] : '';
$tableName = isSet($_REQUEST['tableName']) && $_REQUEST['tableName']!='' ? $_REQUEST['tableName'] : '';
$oldName = isSet($_REQUEST['oldName']) && $_REQUEST['oldName']!='' ? $_REQUEST['oldName'] : '';
$defaultValue = isSet($_REQUEST['defaultValue']) && $_REQUEST['defaultValue']!='' ? $_REQUEST['defaultValue'] : '';
$sys_field_type_id = isSet($_REQUEST['sys_field_type_id']) && $_REQUEST['sys_field_type_id']!='' ? $_REQUEST['sys_field_type_id'] : '';
$fieldSize = isSet($_REQUEST['fieldSize']) && $_REQUEST['fieldSize']!='' ? $_REQUEST['fieldSize'] : '';
$fieldType = isSet($_REQUEST['fieldType']) && $_REQUEST['fieldType']!='' ? $_REQUEST['fieldType'] : '';
$listColumn = isSet($_REQUEST['listColumn']) && $_REQUEST['listColumn']!='' ? $_REQUEST['listColumn'] : '';
$name = '';



/* handle commands */
switch( $cmd ){
	case 'new':
	    /* check sys_section_id */
	    if( $fieldName!='' && $sys_control_id!=''){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQAddField',array('fieldName'=>$fieldName,'displayName'=>$displayName,'sys_control_id'=>$sys_control_id,'controlValues'=>$controlValues,'sys_field_id'=>$sys_field_id,'tableName'=>$tableName,'defaultValue'=>$defaultValue,'sys_field_type_id'=>$sys_field_type_id));
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQAddFieldToTable',array('fieldName'=>$fieldName,'tableName'=>$tableName,'fieldType'=>$fieldType,'fieldSize'=>$fieldSize,'defaultValue'=>$defaultValue,'sys_field_type_id'=>$sys_field_type_id));
        	$sys_field_number++;
	    }
	break;
	case 'update':
	    /* check sys_section_id */
	    if( $fieldName!='' && $sys_control_id!=''){
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQUpdateField',array('fieldName'=>$fieldName,'displayName'=>$displayName,'sys_control_id'=>$sys_control_id,'controlValues'=>$controlValues,'sys_field_id'=>$sys_field_id,'tableName'=>$tableName,'fieldType'=>$fieldType,'fieldSize'=>$fieldSize,'defaultValue'=>$defaultValue,'listColumn'=>$listColumn,'sys_field_type_id'=>$sys_field_type_id));
        	$__APPLICATION_['database']->__runQueryByCode_('__runquery_','FQAlterFieldName',array('oldName'=>$oldName,'newName'=>$fieldName,'tableName'=>$tableName,'fieldType'=>$fieldType,'fieldSize'=>$fieldSize,'defaultValue'=>$defaultValue,'sys_field_type_id'=>$sys_field_type_id));
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


/* get all module fields */
$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'sys_field_type_id'=>'1 or sys_field_type_id=2 or sys_field_type_id=3 or sys_field_type_id=4 or sys_field_type_id=5 or sys_field_type_id=6')),'admin');

// TODO: NB!!!! make field type varialbe

$tableName = $module->moduleValues['sys']['tableName'];
if( isSet($module->moduleValues['fields']) && $sys_field_number!='' ){
	$field = $module->moduleValues['fields'][$sys_field_number];
	$sys_field_id = $field['sys_field_id'];
    $fieldName = $field['name'];
    $displayName = $field['displayName'];
    $controlValues = $field['controlValues'];
    $defaultValue = $field['defaultValue'];
    $sys_control_id = $field['sys_control_id'];
    $sys_field_type_id = $field['sys_field_type_id'];
    $listColumn =  $field['listColumn'];
    $cmd = 'update';
    $name = $field['name'];
}else{
  $sys_field_number = count($module->moduleValues['fields'])-1;
}

$fieldName = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$fieldName,'fieldName'=>'fieldName','displayName'=>'Field Name')),'admin');
$fieldName = $fieldName->output();
$displayName = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$displayName,'fieldName'=>'displayName','displayName'=>'Field Display Name')),'admin');
$displayName = $displayName->output();
$controlValues = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$controlValues,'fieldName'=>'controlValues','displayName'=>'Control Values')),'admin');
$controlValues = $controlValues->output();
$controlsDropdown = new control(array('in'=>array('sys_control_id'=>3,'system_table'=>'sys_control','fieldValue'=>$sys_control_id,'fieldName'=>'sys_control_id','displayName'=>'Select Control')),'admin');
$controlsDropdown = $controlsDropdown->output();
$fieldTypeDropdown = new control(array('in'=>array('sys_control_id'=>3,'system_table'=>'sys_field_type','fieldValue'=>$sys_field_type_id,'fieldName'=>'sys_field_type_id','displayName'=>'Select Field Category')),'admin');
$fieldTypeDropdown = $fieldTypeDropdown->output();
$defaultValue = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$defaultValue,'fieldName'=>'defaultValue','displayName'=>'Default Value')),'admin');
$defaultValue = $defaultValue->output();
$fieldType = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$fieldType,'fieldName'=>'fieldType','displayName'=>'Field Type')),'admin');
$fieldType = $fieldType->output();
$fieldSize = new control(array('in'=>array('sys_control_id'=>1,'fieldValue'=>$fieldSize,'fieldName'=>'fieldSize','displayName'=>'Field Size')),'admin');
$fieldSize = $fieldSize->output();
$listColumn = new control(array('in'=>array('sys_control_id'=>10,'fieldValue'=>$listColumn,'fieldName'=>'listColumn','displayName'=>'List/Search Column','options'=>array('Yes'=>'1','No'=>'0'))),'admin');
$listColumn = $listColumn->output();


/* replace values */
$__APPLICATION_['channel']->channelReplaceLoop('commands',$commands);
$__APPLICATION_['channel']->replace('<var:cmd>',$cmd);
$__APPLICATION_['channel']->replace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:sys_field_id>',$sys_field_id);
$__APPLICATION_['channel']->replace('<var:sys_field_number>',$sys_field_number);
$__APPLICATION_['channel']->replace('<var:name>',$name);
$__APPLICATION_['channel']->replace('<var:fieldName>',$fieldName);
$__APPLICATION_['channel']->replace('<var:oldName>',$name);
$__APPLICATION_['channel']->replace('<var:displayName>',$displayName);
$__APPLICATION_['channel']->replace('<var:controlValues>',$controlValues);
$__APPLICATION_['channel']->replace('<var:controlSelect>',$controlsDropdown);
$__APPLICATION_['channel']->replace('<var:fieldTypeSelect>',$fieldTypeDropdown);
$__APPLICATION_['channel']->replace('<var:defaultValue>',$defaultValue);
$__APPLICATION_['channel']->replace('<var:listColumn>',$listColumn);
$__APPLICATION_['channel']->replace('<var:fieldType>',$fieldType);
$__APPLICATION_['channel']->replace('<var:fieldSize>',$fieldSize);

$__APPLICATION_['channel']->replaceLoop('fields',array());


/* show channel */
$__APPLICATION_['channel']->show();
?>