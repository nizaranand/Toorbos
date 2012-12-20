<?php
$sessionID = isSet( $_REQUEST['PHPSESSID'] ) && $_REQUEST['PHPSESSID'] != '' ? $_REQUEST['PHPSESSID'] : ''; //TODO: make a week ago
session_id( $sessionID );
require_once ("../../../../config/.citadel.config.conf");
require_once 'Image/Transform.php';

$baseName = isSet($_REQUEST['baseName']) ? $_REQUEST['baseName'] : '';
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : '';
$contentId = isSet($_REQUEST['contentId']) ? $_REQUEST['contentId'] : '';
$fieldName = isSet($_REQUEST['fieldName']) ? $_REQUEST['fieldName'] : '';
$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$controlValues = isSet($_REQUEST['controlValues']) ? $_REQUEST['controlValues'] : '';
$fit = isSet($_REQUEST['fit']) ? $_REQUEST['fit'] : '';
error_log($fit);
if( $controlValues!="" ){
	parse_str($controlValues);
}


if( $cmd=='delete' ){
	$query = 'update mod_'.$_REQUEST['tableName'].' set '.$_REQUEST['fieldName'].'="" where mod_'.$_REQUEST['tableName'].'_id='.$_REQUEST['contentId'];
	error_log($query);
	$__APPLICATION_['database']->__runquery_($query);
}

if (!empty($_FILES)) {
		
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$fileName = str_replace('=','-',str_replace(' ','',$_FILES['Filedata']['name']));
	$targetPath = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/';
	error_log($targetPath);
	if( !isSet($_REQUEST['contentId']) || $_REQUEST['contentId']!='' ){
		
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/');

		$targetFile =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/' . $fileName;
		
		error_log($targetFile);

		move_uploaded_file($tempFile,$targetFile);
		
		// resize images
		$sizes = strstr($fit,',') ? split(',',$fit) : array($fit);
		
		
		$i =& Image_Transform::factory('GD');
		foreach( $sizes as $key=>$value ){
			error_log('Doing '.$value);
			$values = array();
			$values['orig'] = $value;
			$values['folder'] = str_replace('x','',$value);
			$dimensions = split('x',$value);
			$values['width'] = $dimensions[0];
			$values['height'] = $dimensions[1];
			
			$sizes[$key] = $values;
			
			$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($tableName).'/'.$contentId.'/'.$values['folder'].'/');

			$targetFiletmp =  $targetPath.'files/'.strtolower($tableName).'/'.$contentId.'/'.$values['folder'].'/' . $fileName;
			
			error_log($targetFiletmp);
			
			$i->load($targetFile);
			$i->fit($values['width'],$values['height']);
			$i->save($targetFiletmp, 'jpg',100);
			
		}
		
	
		$query = 'update mod_'.$_REQUEST['tableName'].' set '.$_REQUEST['fieldName'].'="'.$fileName.'" where mod_'.$_REQUEST['tableName'].'_id='.$_REQUEST['contentId'];
		error_log($query);
		$__APPLICATION_['database']->__runquery_($query);
	
		echo 'files/'.strtolower($tableName).'/'.$contentId.'/'.$values['folder'].'/' . $fileName;
	}
	// } else {
	// 	echo 'Invalid file type.';
	// }
}
?>