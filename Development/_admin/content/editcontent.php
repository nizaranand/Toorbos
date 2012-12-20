<?
require_once(".citadel.config.conf");
$__APPLICATION_['channel'] = new channel(array('in'=>array('path'=>'content','section'=>'editcontent')));
/* do permissions check */
$__APPLICATION_['session'] = new expertSession();

/* resolve vars */
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : '';
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : '';
$mod_content_id = isSet($_REQUEST['mod_content_id']) ? $_REQUEST['mod_content_id'] : '';
$sys_field_type_id = isSet($_REQUEST['sys_field_type_id']) ? $_REQUEST['sys_field_type_id'] : 1;
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';

if( $cmd=='new' ){
	$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName,'sys_field_type_id'=>$sys_field_type_id)),'add');
    $mod_content_id = $module->moduleValues['sys']['mod_content_id'];
}elseif( $cmd=='update' ){
    $module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName,'sys_field_type_id'=>$sys_field_type_id)),'setContent');
}

$cmd = $cmd=='' &&  $mod_content_id==0 ? 'new' : 'update';

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

/* get content options */
$module = new module(array('in'=>array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName,'sys_field_type_id'=>$sys_field_type_id)),'admin');

$moduleDetail = $__APPLICATION_['database']->__runQueryByCode_('fetchrownamed','MQGetModuleDetail',array('sys_module_id'=>$sys_module_id,'mod_content_id'=>$mod_content_id,'tableName'=>$tableName));

$commands = array();
array_push($commands,array('output'=>$__APPLICATION_['channel']->getCommand('newcontent',array('sys_module_id'=>$sys_module_id,'tableName'=>$tableName))));

/* replace values */
$__APPLICATION_['channel']->replace('<var:contentName>',$module->moduleValues['content']['name']);
$__APPLICATION_['channel']->replace('<var:moduleOutput>',$module->output());
$__APPLICATION_['channel']->replaceLoop('commands',$commands);
$__APPLICATION_['channel']->replaceLoop('subCommands',$subCommands);
$__APPLICATION_['channel']->replace('<var:tableName>',$tableName);
$__APPLICATION_['channel']->replace('<var:sys_module_id>',$sys_module_id);
$__APPLICATION_['channel']->replace('<var:mod_content_id>',$mod_content_id);
$__APPLICATION_['channel']->replace('<var:sys_field_type_id>',$sys_field_type_id);
$__APPLICATION_['channel']->replace('<var:cmd>',($cmd=='' ? 'new' : $cmd));
$__APPLICATION_['channel']->replace('<var:moduleName>',$moduleDetail['moduleName']);

/* show channel */
$__APPLICATION_['channel']->show();

?>