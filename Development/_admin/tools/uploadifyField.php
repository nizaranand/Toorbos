<?php
require_once (".citadel.config.conf");
require_once 'Image/Transform.php';

$baseName = isSet($_REQUEST['baseName']) ? $_REQUEST['baseName'] : '';
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : '';
$contentId = isSet($_REQUEST['contentId']) ? $_REQUEST['contentId'] : '';
$type = isSet($_REQUEST['type']) ? $_REQUEST['type'] : 'image';
$fieldName = isSet($_REQUEST['fieldName']) ? $_REQUEST['fieldName'] : '';

// get the control
$field = moduleUtilities::getFieldByName($tableName, $fieldName);
$controlValues = $field['controlValues'];

$cmd = isSet($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
$controlValues = isSet($_REQUEST['controlValues']) ? $_REQUEST['controlValues'] : $controlValues;
$fit = isSet($_REQUEST['fit']) ? $_REQUEST['fit'] : '';
$restriction = isSet($_REQUEST['restriction']) ? $_REQUEST['restriction'] : '';

if( $controlValues!="" ){
	parse_str($controlValues);
}

if( $cmd=='delete' ){
	$query = 'update mod_'.$_REQUEST['tableName'].' set '.$_REQUEST['fieldName'].'="" where mod_'.$_REQUEST['tableName'].'_id='.$_REQUEST['contentId'];
	$__APPLICATION_['database']->__runquery_($query);
	
	//TODO: Unlionk files by looping through sizes if its an image
	
}

if (!empty($_FILES)) {
			
	$tempFile = $_FILES[$fieldName.'-file']['tmp_name'];
	$fileName = str_replace('=','-',str_replace(' ','',$_FILES[$fieldName.'-file']['name']));
	$fileName = str_replace(' ','-',$fileName);
	$targetPath = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/';
	$targetPathRepo = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files/';
	
	error_log($targetPath);
	
	if( !isSet($_REQUEST['contentId']) || $_REQUEST['contentId']!='' ){
		
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/');
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,$restriction.'/');

		if( $type=='image' ){
			$targetPath = $targetPath.'files/'.strtolower($tableName).'/'.$_REQUEST['contentId'].'/';
		}else{
			$targetPath = $targetPath.$restriction.'/';
		}
		
		$targetPathRepo =  $targetPathRepo.$restriction.'/';
					
		$targetFile =  $targetPath.$fileName;
		
		if( $type=='image' ){
			$targetFileRepo =  $targetPathRepo.'files/'.strtolower($tableName).'/'.$_REQUEST['contentId'].'/' . $fileName;
		}else{
			$targetFileRepo =  $targetPathRepo.$fileName;
		}	
		
		error_log($targetFile);

		move_uploaded_file($tempFile,$targetFile);
		copy($targetFile,$targetFileRepo);
		
		if( $type=='image' ){
			// resize images
			$sizes = split(',','100x100,'.$fit);			
			
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
				
				$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,$values['folder'].'/');
				$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPathRepo,$values['folder'].'/');
	
				$targetFiletmp = $targetPath.$values['folder'].'/'.$fileName;
				$targetFiletmpRepo = $targetPathRepo.$values['folder'].'/'.$fileName;
				
				error_log($targetFiletmp);
				
				$i->load($targetFile);
				$i->fit($values['width'],$values['height']);
				$i->save($targetFiletmp, 'jpg',100);
				$i->save($targetFiletmpRepo, 'jpg',100);
				
			}
			
		
			$query = 'update mod_'.$_REQUEST['tableName'].' set '.$_REQUEST['fieldName'].'="'.$fileName.'" where mod_'.$_REQUEST['tableName'].'_id='.$_REQUEST['contentId'];
			error_log($query);
			$__APPLICATION_['database']->__runquery_($query);
			
			$result = array();
			$result['fieldValue'] = $fileName;
			$result['url'] = 'files/'.strtolower($tableName).'/'.$contentId.'/100100/' . $fileName;		
			
		}else{
			$query = 'update mod_'.$_REQUEST['tableName'].' set '.$_REQUEST['fieldName'].'="'.$fileName.'" where mod_'.$_REQUEST['tableName'].'_id='.$_REQUEST['contentId'];
			error_log($query);
			$__APPLICATION_['database']->__runquery_($query);
			
			$result = array();
			$result['fieldValue'] = $fileName; 		
			$result['url'] = $restriction.'/'.$fileName;
			
		}
		echo json_encode($result);die;
	}
}
?>