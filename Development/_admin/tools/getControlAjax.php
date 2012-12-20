<?
ob_start();
// get all vars
require_once(".citadel.config.conf");
require_once("JSON.php");

$moduleName = isSet($_REQUEST['moduleName']) ? $_REQUEST['moduleName'] : '';
$content_id = isSet($_REQUEST['content_id']) ? $_REQUEST['content_id'] : '';
$fieldName = isSet($_REQUEST['fieldName']) ? $_REQUEST['fieldName'] : '';
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : 'get';
$uiId = isSet($_REQUEST['uiId']) ? $_REQUEST['uiId'] : '';
$valuesOnly = isSet($_REQUEST['valuesOnly']) ? $_REQUEST['valuesOnly'] : 'no';
$standalone = isSet($_REQUEST['standalone']) ? $_REQUEST['standalone'] : 'no';

$GLOBALS['dontdie'] = 'yes';

$json = new Services_JSON();

$paths = $__CONFIG_['__paths_'];

$editMode = isSet( $_REQUEST['editMode'] ) ? $_REQUEST['editMode'] : 0;
$createMode = isSet( $_REQUEST['createMode'] ) ? $_REQUEST['createMode'] : 0;
$__APPLICATION_['channel'] = new channel( array('in' => array('path' => 'sites', 'section' => 'www', 'skin' => 'blankChannel.tpl' ) ) );

// check for a custom session object
if( is_file($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/includes/siteSession.php') ){
	include_once($paths['__installationPath_'].'/clients'.$paths['__clientPath_'].'/files/includes/siteSession.php');
}else{
	include_once($paths['__libPath_'].'/siteSession.php');
}

//check for email usage
$useEmail = true;
$GLOBALS['siteSession'] = new siteSession($GLOBALS['__APPLICATION_']['uniqueID'],'mod_applicationUser',$useEmail);

$actualFieldName = $fieldName;

if( !($moduleDetails = moduleUtilities::getByName($moduleName)) ){
	$moduleDetails = moduleUtilities::getByTableName($moduleName);
}

$fieldName = $moduleDetails['tableName'].$fieldName;

$fieldDetails = moduleUtilities::getFieldByName($moduleName, $actualFieldName);
$controlDetails = controlUtilities::get($fieldDetails['sys_control_id']);
$content = content::get($moduleName, $content_id);

$moduleDetails['mod_content_id'] = $content_id;

$field = new control(array('in'=>array('mod_content_id'=>$content_id,'actualFieldName'=>$actualFieldName,'sys_control_id'=>$controlDetails['sys_control_id'],'controlValues'=>$fieldDetails['controlValues'],'tableName'=>$moduleDetails['tableName'],'fieldValue'=>$content[$actualFieldName],'fieldName'=>$fieldName,'displayName'=>$fieldDetails['displayName'],'sys_tree_id'=>0,'content'=>$content,'module'=>$moduleDetails,'editable'=>1,'values-only'=>$valuesOnly)),$cmd);

$result = array(array('output'=>$field->output(),'uiId'=>$uiId));

echo $json->encode($result);
?>