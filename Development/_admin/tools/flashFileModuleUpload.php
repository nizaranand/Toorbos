<?
// get all vars
require_once(".citadel.config.conf");
$resourceID = isSet($_REQUEST['resourceID']) ? $_REQUEST['resourceID'] : 0;
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : $tableName;
$sys_module_id = isSet($_REQUEST['sys_module_id']) ? $_REQUEST['sys_module_id'] : $sys_module_id;
$fieldName = isSet($_REQUEST['fieldName']) ? $_REQUEST['fieldName'] : $fieldName;
$destinationPath = isSet($_REQUEST['destinationPath']) ? $_REQUEST['destinationPath'] : $destinationPath;
$destinationURL = isSet($_REQUEST['destinationURL']) ? $_REQUEST['destinationURL'] : $destinationURL;

$uploadedfile   = $_FILES['Filedata']['tmp_name'];
$filename               = $_FILES['Filedata']['name'];

${$fieldName} = $destinationURL.'/'.$filename;
$GLOBALS['_REQUEST'][$fieldName] = ${$fieldName};
$__APPLICATION_['utilities']->createFoldersRecursive("",$destinationPath);
$destinationPath = $destinationPath.''.$filename;

error_log(move_uploaded_file($_FILES['Filedata']['tmp_name'],$destinationPath),3,"/tmp/test.log");

if( $resourceID!=0 && $resourceID!="" ){
  $__APPLICATION_['utilities']->updateModule( $tableName, Array(Array("name"=>$fieldName)), $resourceID );  
  $__APPLICATION_['utilities']->updateModule( $tableName, Array(Array("name"=>$fieldName)), $resourceID );  
   sleep(2);
   system("cp -rf ".$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files/* '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/.');
  error_log($destinationPath."-".$tableName." - ".$fieldName." - ".$resourceID,3,"/tmp/test.log");
	$message =  "<result><status>OK</status><message>$file_name uploaded successfully.</message></result>";
}else{
	$message = "<result><status>Error</status><message>Somthing is wrong with uploading a file.</message></result>";
}

echo $message;
?>
