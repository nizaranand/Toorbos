<?
// get all vars
require_once(".citadel.config.conf");

$q = strtolower($_REQUEST["q"]);
$tableName = $_REQUEST["tableName"];

if (!$q) return;

$items = $__APPLICATION_['database']->fetcharray("select * from mod_".$tableName." where LOWER(name) like LOWER(\"%".$q."%\")");

foreach ($items as $key=>$value) {
		echo $value['name'].'|'.$value['mod_'.$tableName.'_id']."\n";
}

?>
