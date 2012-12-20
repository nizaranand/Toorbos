<?
//header('Content-type: text/json');

// get all vars
require_once(".citadel.config.conf");
require_once("JSON.php");

$json = new Services_JSON();

$q = strtolower($_REQUEST["q"]);
$tableName = $_REQUEST["tableName"];
$fieldToPopulate = $_REQUEST['fieldToPopulate'];
$fieldValue = $_REQUEST['fieldValue'];
$useId = $_REQUEST['useId'];

//if (!$q) return;

$moduleDetails = moduleUtilities::getByName($tableName);
$tableName = $moduleDetails['tableName'];

$items = $__APPLICATION_['database']->fetcharray("select '".$useId."' as useId, '".$fieldValue."' as fieldValue,'".$fieldToPopulate."' as fieldToPopulate,mod_".$tableName.".name as contentName,mod_".$tableName.".mod_".$tableName."_id as contentId from mod_".$tableName.($q!='' ? " where LOWER(name) like LOWER(\"%".$q."\")" : "")." order by name");

echo $json->encode($items);

?>
