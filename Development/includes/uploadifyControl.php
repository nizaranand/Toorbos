<?php
$sessionID = isSet( $_REQUEST['PHPSESSID'] ) && $_REQUEST['PHPSESSID'] != '' ? $_REQUEST['PHPSESSID'] : ''; //TODO: make a week ago
session_id( $sessionID );
require_once ("../../../../config/.citadel.config.conf");
require_once 'Image/Transform.php';

$baseName = isSet($_REQUEST['baseName']) ? $_REQUEST['baseName'] : '';
$tableName = isSet($_REQUEST['tableName']) ? $_REQUEST['tableName'] : '';
$contentId = isSet($_REQUEST['contentId']) ? $_REQUEST['contentId'] : '';
$fieldName = isSet($_REQUEST['fieldName']) ? $_REQUEST['fieldName'] : '';

if (!empty($_FILES)) {

	if( $contentId!='' ){
		// get the control details
		$query = 'select * from sys_'.$tableName.'_fields where name="'.$fieldName.'"';
		$controlValues =  $__APPLICATION_['database']->fetchrownamed($query);

		// check if this is the first image and if so make it the primary
		$query = 'select '.$fieldName.' from mod_'.$tableName.' where mod_'.$tableName.'_id='.$contentId;

		error_log($query);

		$result = $__APPLICATION_['database']->fetchrownamed($query);

		$fieldValue = $result[$fieldName];

		error_log($fieldValue);

		if( $result[$fieldName]=='' ){
			$isPrimary = 'yes';
		}else{
			$isPrimary = 'no';
		}

		$tempFile = $_FILES['Filedata']['tmp_name'];
		$fileName = str_replace('=','-',str_replace(' ','',$_FILES['Filedata']['name']));
		$targetPath = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/';
		error_log($targetPath);
			
		// calcualte the rezies
		parse_str($controlValues['controlValues']);

		$sizes = strstr($fit,',') ? split(',',$fit) : array($fit);

		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($tableName).'/'.$contentId.'/'.$fieldName);
		$targetFile =  $targetPath.'files/'.strtolower($tableName).'/'.$contentId.'/'.$fieldName.'/'. $fileName;
		move_uploaded_file($tempFile,$targetFile);

		$i =& Image_Transform::factory('GD');

		foreach( $sizes as $key=>$value ){

			$values = array();
			$values['orig'] = $value;
			$values['folder'] = str_replace('x','',$value);
			$dimensions = split('x',$value);
			$values['width'] = $dimensions[0];
			$values['height'] = $dimensions[1];

			$sizes[$key] = $values;

			$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($tableName).'/'.$contentId.'/'.$fieldName.'/'.$values['folder'].'/');

			$targetFiletmp =  $targetPath.'files/'.strtolower($tableName).'/'.$contentId.'/'.$fieldName.'/'.$values['folder'].'/' . $fileName;

			$i->load($targetFile);
			$i->fit($values['width'],$values['height']);
			$i->save($targetFiletmp, 'jpg',100);

		}

		// get the current images
		if( strstr($fieldValue,',') ){
			$images = explode(',',$fieldValue);
		}else{
			$images = array($fieldValue);
		}
		
		/*$imageValues = array();
		$exists = false;

		foreach( $images as $key=>$value ){
			$values = explode('|',$value);
			array_push($imageValues,array('src'=>$values[0],'alt'=>$values[1],'primary'=>$values[2]));
			if( $values[0]==$fileName ){
				$exists = true;
			}
		}*/

		if( $fileName!='' ){
			//$fieldValue .= ($fieldValue!='' ? ',' : '').$fileName.'||'.$isPrimary;
			$query = 'select * from mod_picture where picture="'.$fileName.'" and moduleType="'.$tableName.'" and contentId='.$contentId;

			if( !($__APPLICATION_['database']->fetchrownamed($query)) ){
				$query = 'insert into mod_picture(name,picture,moduleType,contentId,title,isPrimary) values("'.$fileName.'","'.$fileName.'","'.$tableName.'","'.$contentId.'","","'.$isPrimary.'")';
				$__APPLICATION_['database']->__runquery_($query);
			}
		}

		/*$query = 'update mod_'.$tableName.' set '.$fieldName.'="'.$fieldValue.'" where mod_'.$tableName.'_id='.$contentId;

		error_log($query);

		$__APPLICATION_['database']->__runquery_($query);*/

			
		echo 'files/'.strtolower($tableName).'/'.$contentId.'/'.$fieldName.'/'.$values['folder'].'/' . $fileName;
	}
}
?>