<?php
$sessionID = isSet( $_REQUEST['PHPSESSID'] ) && $_REQUEST['PHPSESSID'] != '' ? $_REQUEST['PHPSESSID'] : ''; //TODO: make a week ago
session_id( $sessionID );
require_once ("../../../../config/.citadel.config.conf");
require_once 'Image/Transform.php';

$baseName = isSet($_REQUEST['baseName']) ? $_REQUEST['baseName'] : '';

if (!empty($_FILES)) {

	// check if this is the first image and if so make it the primary
	$query = 'select * from mod_picture where moduleType="'.$_REQUEST['tableName'].'" and picture != "/pic_default.jpg" and contentId='.$_REQUEST['contentId'];

	if( !($__APPLICATION_['database']->fetcharray($query)) ){
		$isPrimary = 'yes';
	}else{
		$isPrimary = '';
	}

	$tempFile = $_FILES['Filedata']['tmp_name'];
	$fileName = str_replace('=','-',str_replace(' ','',$_FILES['Filedata']['name']));
	$targetPath = $__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/'.$__CONFIG_['__paths_']['__httpPath_'].'/';
	error_log($targetPath);
	if( !isSet($_REQUEST['contentId']) || $_REQUEST['contentId']!='' ){
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/');
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/214143/');
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/130187/');
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/165110/');
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/641253/');
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/606375/');
		$GLOBALS['__APPLICATION_']['utilities']->createFoldersRecursive($targetPath,'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/gradient/');

		$targetFile =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/' . $fileName;
		$targetFile130187 =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/130187/' . $fileName;
		$targetFile165110 =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/165110/' . $fileName;
		$targetFile214143 =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/214143/' . $fileName;
		$targetFile641253 =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/641253/' . $fileName;
		$targetFile606375 =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/606375/' . $fileName;
		$targetFileGradient =  $targetPath.'files/'.strtolower($_REQUEST['tableName']).'/'.$_REQUEST['contentId'].'/gradient/' . $fileName;


		error_log($targetFile);

		move_uploaded_file($tempFile,$targetFile);

		// resize images


		$i =& Image_Transform::factory('GD');

		$i->load($targetFile);
		$i->fit(130,187);
		$i->save($targetFile130187, 'jpg');

		$i->load($targetFile);
		$i->fit(165,110);
		$i->save($targetFile165110, 'jpg');

		$i->load($targetFile);
		$i->fit(214,143);
		$i->save($targetFile214143, 'jpg');

		$i->load($targetFile);
		$i->fit(641,253);
		$i->save($targetFile641253, 'jpg');

		$i->load($targetFile);
		$i->fit(606,375);
		$i->save($targetFile606375, 'jpg');


		$query = 'insert into mod_picture(name,picture,moduleType,contentId'.($isPrimary!='' ? ',isPrimary' : '').') values("'.$_FILES['Filedata']['name'].'","'.$fileName.'","'.$_REQUEST['tableName'].'",'.$_REQUEST['contentId'].($isPrimary!='' ? ',"'.$isPrimary.'"' : '').')';
		error_log($query);
		$__APPLICATION_['database']->__runquery_($query);
		
		$picture_id = $__APPLICATION_['database']->__lastID_();

		$i->load($targetFile);
		if( $i->getImageHeight()>=233 && $i->getImageWidth()>=440 ){
			$i->fit(440,440);
			$i->save($targetFileGradient, 'jpg');

			$draw = new ImagickDraw();
			$im = new Imagick($targetFileGradient);

			$gradient = new Imagick();
			$gradient->newImage($im->getImageWidth(), 40, new ImagickPixel("black"));
			$gradient->setImageOpacity(0.5);
			$im->compositeImage($gradient, imagick::COMPOSITE_OVER, 0, $im->getImageHeight()-40);

			/* Black text */
			$draw->setFillColor('white');

			/* Font properties */
			$draw->setFont('TrajanPro-Bold.otf');
			$draw->setFontWeight(600);
			$draw->setFontSize( 14 );

			/* Create text */
			$im->annotateImage($draw,10, $im->getImageHeight()-15, 0, $details['title']);

			try{
				try{
					$diff = $im->getImageHeight()-233;
					if( $diff>0 ){
						$im->cropImage($im->getImageWidth(),$im->getImageHeight()-$diff,0,$diff);
					}
				}catch(Exception $error){
					echo $error."<br/>";
				}
			}catch(Exception $error){
				echo $error."<br/>";
			}


			$im->writeImage($targetFileGradient);

			$im->clear();
			$im->destroy();
			$gradient->clear();
			$gradient->destroy();
			$query = 'update mod_picture set canTitle="yes" where mod_picture_id='.$picture_id;
			$pictures = $__APPLICATION_['database']->__runquery_($query);
		}else{
			$query = 'update mod_picture set canTitle="no" where mod_picture_id='.$_REQUEST['contentId'];
			$pictures = $__APPLICATION_['database']->__runquery_($query);
		}

		echo "1";
	}
	// } else {
	// 	echo 'Invalid file type.';
	// }
}
?>