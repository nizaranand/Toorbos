<?
require_once(".citadel.config.conf");


// get all modules
$db = $GLOBALS['__APPLICATION_']['database'];
$modules = $db->fetcharray('select * from sys_module');
// check for recipricol control
foreach( $modules as $key=>$value ){
	$moduleHasControl = $db->fetcharray('select * from sys_'.$value['tableName'].'_fields where sys_control_id='.
}


// update




?>