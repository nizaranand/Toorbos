<?
require_once(".citadel.config.conf");
$sys_field_type_id = 1;
if( !isSet($_REQUEST['sys_tree_id']) ){
	die("asdasdasD");
}else{
	$sys_tree_id = $_REQUEST['sys_tree_id'];
	error_log($sys_tree_id);
	$module = new module(array('in'=>array('sys_tree_id'=>$sys_tree_id,'currentPath'=>'','sys_field_type_id'=>$sys_field_type_id)),'setContent');
}
?>